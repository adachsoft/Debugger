<?php

declare(strict_types=1);

namespace Tests\Unit;

use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\ParserInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Debugger::class)]
final class DebuggerTest extends TestCase
{
    public function testVarDumpLogsOutput(): void
    {
        // Arrange
        $log = $this->createMock(LogInterface::class);
        $parser = $this->createMock(ParserInterface::class);

        $capturedMessage = null;
        $log->expects($this->once())
            ->method('log')
            ->willReturnCallback(static function (string $message) use (&$capturedMessage): void {
                $capturedMessage = $message;
            });

        $sut = new Debugger($log, $parser);

        // Act
        $sut->varDump('test');

        // Assert
        self::assertIsString($capturedMessage);
        self::assertStringContainsString('DebuggerTest.php', $capturedMessage);
    }

    public function testBackTraceLogsOutput(): void
    {
        // Arrange
        $log = $this->createMock(LogInterface::class);
        $parser = $this->createMock(ParserInterface::class);

        $log->expects($this->once())->method('log');

        $sut = new Debugger($log, $parser);

        // Act
        $sut->backTrace();

        // Assert
        // Assertions are performed by mock expectations.
    }
}
