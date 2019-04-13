<?php

namespace AdachSoft\Debugger;

class Debugger
{
    use SingletonTrait;

    /**
     * Log class.
     *
     * @var LogInterface
     */
    public $logClass;

    /**
     * Determines whether logs are enabled.
     *
     * @var boolean
     */
    public $isOn = true;
    public $time = 0.0;
    public $lastTime = 0.0;

    /**
     *
     *
     * @var integer
     */
    public $cntTime = 0;

    /**
     * Number of calls.
     *
     * @var integer
     */
    public $numberOfCalls = 0;

    /**
     * Parser class;
     *
     * @var ParserInterface
     */
    public $parser;

    public $dateFormat = 'Y-m-d H:i:s';
    public $endLine = PHP_EOL;

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
        if (false === self::$singleton) {
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

    public function varDump()
    {
        $str = "VAR_DUMP[{$this->numberOfCalls}]: " . date($this->dateFormat) . $this->endLine .  $this->endLine;
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        ob_start();
        echo $caller['file'] . ' ' . $caller['line'] .  $this->endLine;
        $numargs = func_num_args();
        for ($i = 0; $i < $numargs; ++$i) {
            $this->parser->parse(func_get_arg($i));
            echo $this->endLine;
        }
        $str .= ob_get_clean() .  $this->endLine;
        $this->logRaw($str);
        $this->numberOfCalls++;
    }
    
    public function startTime()
    {
        $this->lastTime = $this->time = \microtime(true);
    }
    
    public function stopTime(string $label = ''): float
    {
        $mt = \microtime(true);
        $t = $mt - $this->time;
        $t1 = $mt - $this->lastTime;
        $str = '';
        if (!empty($label)) {
            $str = "[$label]";
        }
        static::logRaw('>TIME ' . $this->cntTime . "{$str}: {$t}s, {$t1}s".$this->endLine);
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
}
