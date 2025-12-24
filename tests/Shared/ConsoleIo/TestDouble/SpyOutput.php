<?php

declare(strict_types=1);

namespace Tests\Shared\ConsoleIo\TestDouble;

use Adachsoft\ConsoleIo\Output\OutputInterface;

/**
 * Test double for capturing CLI output.
 */
final class SpyOutput implements OutputInterface
{
    private string $output = '';

    private string $errorOutput = '';

    public function write(string $message): void
    {
        $this->output .= $message;
    }

    public function writeLine(string $message): void
    {
        $this->write($message . PHP_EOL);
    }

    public function writeError(string $message): void
    {
        $this->errorOutput .= $message;
    }

    public function writeErrorLine(string $message): void
    {
        $this->writeError($message . PHP_EOL);
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public function getErrorOutput(): string
    {
        return $this->errorOutput;
    }
}
