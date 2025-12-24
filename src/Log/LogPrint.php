<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

use Adachsoft\ConsoleIo\Output\CliOutput;
use Adachsoft\ConsoleIo\Output\OutputInterface;

final class LogPrint implements LogInterface
{
    public function __construct(
        private readonly OutputInterface $output = new CliOutput()
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function log(string $message): void
    {
        $this->output->write($message);
    }
}
