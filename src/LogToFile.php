<?php

namespace AdachSoft\Debugger;

class LogToFile implements LogInterface
{
    public $fileName = 'log.txt';

    /**
     * {@inheritDoc}
     *
     */
    public function log(string $message)
    {
        file_put_contents($this->fileName, $message);
    }
}
