<?php

declare(strict_types=1);

namespace Tests\Unit\Log;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogPrint;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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
        $this->assertInstanceOf(LogInterface::class, $result);
    }

    public function testLogPrintsMessage(): void
    {
        // Arrange
        $sut = new LogPrint();
        $this->expectOutputString('test message');

        // Act
        $sut->log('test message');

        // Assert
        // Assertions are performed by expectOutputString().
    }
}
