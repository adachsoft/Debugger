<?php

namespace AdachSoft\Debugger;

use AdachSoft\Debugger\Log\LogInterface;

class Debugger
{
    use SingletonTrait;

    /**
     * Determines whether logs are enabled.
     *
     * @var boolean
     */
    public $isOn = true;

    /**
     * @var string
     */
    public $dateFormat = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    public $endLine = PHP_EOL;

    /**
     * Log class.
     *
     * @var LogInterface
     */
    private $logClass;

    /**
     * Parser class;
     *
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var float
     */
    private $time = 0.0;
    
    /**
     * @var float
     */
    private $lastTime = 0.0;

    /**
     * @var integer
     */
    private $cntTime = 0;

    /**
     * Number of calls.
     *
     * @var integer
     */
    private $numberOfCalls = 0;

    private function __construct(LogInterface $logClass, ParserInterface $parser)
    {
        $this->logClass = $logClass;
        $this->parser = $parser;
    }

    /**
     * Get get instance.
     *
     * @param LogInterface $logClass
     * @param ParserInterface $parser
     * @return self
     */
    public static function getInstance(LogInterface $logClass, ParserInterface $parser): self
    {
        if (null === self::$singleton) {
            self::$singleton = new self($logClass, $parser);
        }

        return self::$singleton;
    }

    /**
     * Display all erros.
     *
     * @return void
     */
    public static function showAllErrors()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public function setErrorHandler()
    {
        set_error_handler([$this, 'errorHandler']);
    }

    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline)
    {
        $str = $this->errorNumberToString($errno) . "[" . date($this->dateFormat) . "]: {$this->endLine}{$errstr} in {$errfile} {$errline}" . $this->endLine . $this->endLine;
        $this->logRaw($str);

        return true;
    }

    public function varDump(): void
    {
        $str = $this->printFirstLine();
        $str .= "VAR_DUMP[{$this->numberOfCalls}]: " . date($this->dateFormat) . $this->endLine .  $this->endLine;
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        ob_start();
        echo $caller['file'] . ' ' . $caller['line'] . $this->endLine;
        $numargs = func_num_args();
        for ($i = 0; $i < $numargs; ++$i) {
            $this->parser->parse(func_get_arg($i));
            echo $this->endLine;
        }
        $str .= ob_get_clean() .  $this->endLine;
        $this->logRaw($str);
        $this->numberOfCalls++;
    }

    public function backTrace(bool $reverse = false, ?int $limit = null): void
    {
        $cntCall = 0;
        $message = $this->printFirstLine();
        $backTraceStack = debug_backtrace();
        if ($reverse) {
            $backTraceStack = array_reverse($backTraceStack);
        }
        foreach($backTraceStack as $backTraceRow) {
            if ($limit !== null && $limit <= $cntCall) {
                break;
            }
            $message .= "[{$this->numberOfCalls}][{$cntCall}]: " . $backTraceRow['file'] . ':' . $backTraceRow['line'] . $this->endLine;
            $cntCall++;
        }

        $this->logRaw($message);
        $this->numberOfCalls++;
    }

    /**
     * Start timing.
     *
     * @return void
     */
    public function startTime(): void
    {
        $this->lastTime = $this->time = \microtime(true);
    }
    
    /**
     * Stop the stopwatch and measure the time.
     *
     * @param string $label
     * @return float
     */
    public function stopTime(string $label = ''): float
    {
        $mt = \microtime(true);
        $t = $mt - $this->time;
        $t1 = $mt - $this->lastTime;
        $str = '';
        if (!empty($label)) {
            $str = "[$label]";
        }
        $this->logRaw('>TIME ' . $this->cntTime . "{$str}: {$t}s, {$t1}s".$this->endLine);
        ++$this->cntTime;
        $this->lastTime = $mt;
        
        return $t;
    }

    private function logRaw(string $log)
    {
        if ($this->isOn) {
            $this->logClass->log($log);
        }
    }

    /**
     * Error number to string.
     *
     * @param integer $errNo
     * @return string
     */
    private function errorNumberToString(int $errNo): string
    {
        switch ($errNo) {
            case E_USER_ERROR:
            case E_ERROR:
                return 'ERROR';
            case E_USER_WARNING:
            case E_WARNING:
                return 'WARNING';
            case E_USER_NOTICE:
            case E_NOTICE:
                return 'NOTICE';
        }

        return 'UNKNOWN ERROR';
    }

    private function printFirstLine(): string
    {
        $line = '';
        if (0 === $this->numberOfCalls){
            for($i=0; $i < 48; ++$i){
                $line .= '-';
            }
            $line .= $this->endLine;
        }

        return $line;
    }
}
