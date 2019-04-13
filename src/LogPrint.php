<?php

namespace AdachSoft\Debugger;

class LogPrint implements LogInterface
{
    /**
     * {@inheritDoc}
     *
     */
    public function log(string $message)
    {
        echo $message;
    }
}
