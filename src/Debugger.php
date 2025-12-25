<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

use AdachSoft\Debugger\Log\LogInterface;
use ReflectionClass;

class Debugger
{
    /**
     * Determines whether logs are enabled.
     */
    public bool $isOn = true;

    public string $dateFormat = 'Y-m-d H:i:s';

    public string $endLine = PHP_EOL;

    private float $time = 0.0;

    private float $lastTime = 0.0;

    private int $cntTime = 0;

    /**
     * Number of calls.
     */
    private int $numberOfCalls = 0;

    public function __construct(
        private readonly LogInterface $logClass,
        private readonly ParserInterface $parser
    ) {
    }

    /**
     * Display all errors.
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

        $str = $this->errorNumberToString($errno)
            . '['
            . date($this->dateFormat)
            . ']:'
            . $this->endLine
            . $errstr
            . " in {$errfile} {$errline}"
            . $this->endLine
            . $this->endLine;

        $this->logRaw($str);

        return true;
    }

    public function varDump(mixed ...$vars): void
    {
        $str = $this->printFirstLine();
        $str .= "VAR_DUMP[{$this->numberOfCalls}]: " . date($this->dateFormat) . $this->endLine . $this->endLine;

        $caller = $this->resolveCallerFrame();

        $file = (string) ($caller['file'] ?? 'unknown');
        $line = (int) ($caller['line'] ?? 0);

        $str .= $file . ' ' . $line . $this->endLine;

        foreach ($vars as $var) {
            $parsed = rtrim($this->parser->parse($var), "\r\n");
            $str .= $parsed . $this->endLine . $this->endLine;
        }

        $str .= $this->endLine;

        $this->logRaw($str);
        ++$this->numberOfCalls;
    }

    public function backTrace(bool $reverse = false, ?int $limit = null): void
    {
        $cntCall = 0;
        $message = $this->printFirstLine();

        $backTraceStack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        array_shift($backTraceStack);

        if ($reverse) {
            $backTraceStack = array_reverse($backTraceStack);
        }

        foreach ($backTraceStack as $backTraceRow) {
            if ($this->shouldSkipFrame($backTraceRow)) {
                continue;
            }

            if (null !== $limit && $limit <= $cntCall) {
                break;
            }

            $file = $backTraceRow['file'] ?? 'unknown';
            $line = $backTraceRow['line'] ?? '?';

            $message .= "[{$this->numberOfCalls}][{$cntCall}]: {$file}:{$line}{$this->endLine}";
            ++$cntCall;
        }

        $this->logRaw($message);
        ++$this->numberOfCalls;
    }

    /**
     * Start timing.
     */
    public function startTime(): void
    {
        $this->lastTime = $this->time = microtime(true);
    }

    /**
     * Stop the stopwatch and measure the time.
     */
    public function stopTime(string $label = ''): float
    {
        $mt = microtime(true);
        $t = $mt - $this->time;
        $t1 = $mt - $this->lastTime;

        $labelPart = '';
        if ('' !== $label) {
            $labelPart = "[{$label}]";
        }

        $this->logRaw('>TIME ' . $this->cntTime . "{$labelPart}: {$t}s, {$t1}s" . $this->endLine);
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

    private function errorNumberToString(int $errNo): string
    {
        return match ($errNo) {
            E_USER_ERROR, E_ERROR => 'ERROR',
            E_USER_WARNING, E_WARNING => 'WARNING',
            E_USER_NOTICE, E_NOTICE => 'NOTICE',
            default => 'UNKNOWN ERROR',
        };
    }

    /**
     * Returns the frame that called Debugger::varDump().
     *
     * @return array<string, mixed>
     */
    private function resolveCallerFrame(): array
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        foreach ($backtrace as $frame) {
            if ($this->shouldSkipFrame($frame)) {
                continue;
            }

            return $frame;
        }

        return ['file' => 'unknown', 'line' => 0];
    }

    /**
     * @param array<string, mixed> $frame
     */
    private function shouldSkipFrame(array $frame): bool
    {
        if (!isset($frame['file'])) {
            return true;
        }

        $file = $this->normalizePath((string) $frame['file']);

        // Skip Debugger itself
        if ($file === $this->normalizePath(__FILE__)) {
            return true;
        }

        // Skip PHPUnit
        if (str_contains($file, '/vendor/phpunit/')) {
            return true;
        }
        if (str_contains($file, '/vendor/bin/phpunit')) {
            return true;
        }

        // Skip Global Facade D
        if (class_exists('D')) {
            $dFile = (new ReflectionClass('D'))->getFileName();
            if ($dFile && $this->normalizePath($dFile) === $file) {
                return true;
            }
        }

        return false;
    }

    private function normalizePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }

    private function printFirstLine(): string
    {
        if (0 === $this->numberOfCalls) {
            return str_repeat('-', 48) . $this->endLine;
        }

        return '';
    }
}
