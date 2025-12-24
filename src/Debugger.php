<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

use AdachSoft\Debugger\Log\LogInterface;

class Debugger
{
    use SingletonTrait;

    /**
     * Determines whether logs are enabled.
     */
    public bool $isOn = true;

    public string $dateFormat = 'Y-m-d H:i:s';

    public string $endLine = PHP_EOL;

    /**
     * Log class.
     */
    private LogInterface $logClass;

    /**
     * Parser class;
     */
    private ParserInterface $parser;

    private float $time = 0.0;
    
    private float $lastTime = 0.0;

    private int $cntTime = 0;

    /**
     * Number of calls.
     */
    private int $numberOfCalls = 0;

    private function __construct(LogInterface $logClass, ParserInterface $parser)
    {
        $this->logClass = $logClass;
        $this->parser = $parser;
    }

    /**
     * Get instance.
     *
     * @param LogInterface $logClass
     * @param ParserInterface $parser
     * @return self
     */
    public static function getInstance(LogInterface $logClass, ParserInterface $parser): self
    {
        if (null === self::$singleton) {
            self::$singleton = new self($logClass, $parser);
        } else {
            // Fix: Update dependencies to ensure the requested configuration is applied
            self::$singleton->logClass = $logClass;
            self::$singleton->parser = $parser;
        }

        return self::$singleton;
    }

    /**
     * Display all errors.
     *
     * @return void
     */
    public static function showAllErrors(): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }

    public function setErrorHandler(): void
    {
        set_error_handler([$this, 'errorHandler']);
    }

    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $str = $this->errorNumberToString($errno) . "[" . date($this->dateFormat) . "]: {$this->endLine}{$errstr} in {$errfile} {$errline}" . $this->endLine . $this->endLine;
        $this->logRaw($str);

        return true;
    }

    public function varDump(mixed ...$vars): void
    {
        $str = $this->printFirstLine();
        $str .= "VAR_DUMP[{$this->numberOfCalls}]: " . date($this->dateFormat) . $this->endLine .  $this->endLine;
        
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $caller = $bt[0] ?? ['file' => 'unknown', 'line' => 0];
        
        ob_start();
        echo ($caller['file'] ?? 'unknown') . ' ' . ($caller['line'] ?? 0) . $this->endLine;
        
        foreach ($vars as $var) {
            $this->parser->parse($var);
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
            
            $file = $backTraceRow['file'] ?? 'unknown';
            $line = $backTraceRow['line'] ?? '?';
            
            $message .= "[{$this->numberOfCalls}][{$cntCall}]: " . $file . ':' . $line . $this->endLine;
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

    private function logRaw(string $log): void
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
        return match ($errNo) {
            E_USER_ERROR, E_ERROR => 'ERROR',
            E_USER_WARNING, E_WARNING => 'WARNING',
            E_USER_NOTICE, E_NOTICE => 'NOTICE',
            default => 'UNKNOWN ERROR',
        };
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
