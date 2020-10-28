<?php

namespace AdachSoft\Debugger\Log;

class LogHtml implements LogInterface
{
    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        echo "<pre>{$message}</pre>";
    }
}
