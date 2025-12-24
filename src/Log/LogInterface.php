<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

interface LogInterface
{
    /**
     * Log message.
     */
    public function log(string $message): void;
}
