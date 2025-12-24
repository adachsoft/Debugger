<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

class LogToFile implements LogInterface
{
    public function __construct(
        public string $fileName = 'log.txt'
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        file_put_contents($this->fileName, $message, FILE_APPEND | LOCK_EX);
    }
}
