<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

class LogPrint implements LogInterface
{
    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        echo $message;
    }
}
