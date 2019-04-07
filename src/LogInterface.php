<?php

namespace AdachSoft\Debugger;

interface LogInterface{
    /**
     * Log message.
     *
     * @param string $message
     * @return void
     */
    public function log(string $message);
}