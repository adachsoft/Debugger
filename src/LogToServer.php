<?php

namespace AdachSoft\Debugger;

class LogToServer implements LogInterface{
    public $host = '127.0.0.1';
    public $port = 2160;

    /**
     * {@inheritDoc}
     *
     */
    public function log(string $message)
    {
        $this->sendLog($message);
    }

    /**
     * Send log to server.
     *
     * @param string $str
     * @return void
     */
    private function sendLog(string $str)
    {
        $fp = fsockopen($this->host, $this->port, $errno, $errstr, 30);
        if ($fp) {
            fwrite($fp, $str);
            fclose($fp);
        }
    }
}