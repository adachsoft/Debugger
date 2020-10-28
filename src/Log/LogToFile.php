<?php

namespace AdachSoft\Debugger\Log;

class LogToFile implements LogInterface
{
    public $fileName = 'log.txt';

    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        file_put_contents($this->fileName, $message);
    }
}
