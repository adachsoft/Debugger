<?php

namespace AdachSoft\Debugger\Log;

interface LogInterface
{
    /**
     * Log message.
     *
     * @param string $message
     * @return void
     */
    public function log(string $message): void;
}
