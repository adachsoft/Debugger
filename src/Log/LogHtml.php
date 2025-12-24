<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Log;

use Adachsoft\ConsoleIo\Output\CliOutput;
use Adachsoft\ConsoleIo\Output\OutputInterface;

final class LogHtml implements LogInterface
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
        $safeMessage = htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $this->output->write("<pre>{$safeMessage}</pre>");
    }
}
