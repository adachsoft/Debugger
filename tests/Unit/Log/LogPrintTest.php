<?php

declare(strict_types=1);

namespace Tests\Unit\Log;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogPrint;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\Shared\ConsoleIo\TestDouble\SpyOutput;

#[CoversClass(LogPrint::class)]
final class LogPrintTest extends TestCase
{
    public function testItImplementsLogInterface(): void
    {
        // Arrange
        $sut = new LogPrint();

        // Act
        $result = $sut;

        // Assert
        self::assertInstanceOf(LogInterface::class, $result);
    }

    public function testLogWritesMessageToOutput(): void
    {
        // Arrange
        $output = new SpyOutput();
        $sut = new LogPrint($output);

        // Act
        $sut->log('test message');

        // Assert
        self::assertSame('test message', $output->getOutput());
    }
}
