<?php

namespace AdachSoft\Debugger\Log;

class LogToServer implements LogInterface
{
    /**
     * Host
     *
     * @var string
     */
    public $host = '127.0.0.1';
    
    /**
     * Port
     *
     * @var integer
     */
    public $port = 2160;

    /**
     * {@inheritDoc}
     *
     */
    public function log(string $message): void
    {
        $this->sendLog($message);
    }

    /**
     * Send log to server.
     *
     * @param string $str
     * @return void
     */
    private function sendLog(string $str): void
    {
        $fp = fsockopen($this->host, $this->port, $errno, $errstr, 30);
        if ($fp) {
            fwrite($fp, $str);
            fclose($fp);
        }
    }
}
