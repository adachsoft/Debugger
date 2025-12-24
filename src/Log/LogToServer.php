<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

class LogToServer implements LogInterface
{
    public function __construct(
        public string $host = '127.0.0.1',
        public int $port = 2160
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        $this->sendLog($message);
    }

    /**
     * Send log to server.
     */
    private function sendLog(string $str): void
    {
        // Suppress warnings to handle error manually, or use try/catch if converting errors to exceptions
        $fp = @fsockopen($this->host, $this->port, $errno, $errstr, 3);
        
        if ($fp) {
            fwrite($fp, $str);
            fclose($fp);
        }
    }
}
