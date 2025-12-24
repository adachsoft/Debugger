<?php

declare(strict_types=1);

namespace Tests\Unit;

use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\ParserInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\D::class)]
final class DTest extends TestCase
{
    protected function tearDown(): void
    {
        \D::reset();

        parent::tearDown();
    }

    public function testDumpDelegatesToDebuggerVarDump(): void
    {
        // Arrange
        $log = $this->createMock(LogInterface::class);
        $parser = $this->createMock(ParserInterface::class);

        $parser->expects(self::once())
            ->method('parse')
            ->willReturn('parsed');

        $capturedMessage = null;
        $log->expects(self::once())
            ->method('log')
            ->willReturnCallback(static function (string $message) use (&$capturedMessage): void {
                $capturedMessage = $message;
            });

        $debugger = new Debugger($log, $parser);
        \D::setInstance($debugger);

        // Act
        \D::dump('value');

        // Assert
        self::assertIsString($capturedMessage);
        self::assertStringContainsString(__FILE__, $capturedMessage);
        self::assertStringNotContainsString('src/D.php', $capturedMessage);
    }

    public function testEnableChangesUnderlyingDebuggerFlag(): void
    {
        // Arrange
        $log = $this->createMock(LogInterface::class);
        $parser = $this->createMock(ParserInterface::class);

        $debugger = new Debugger($log, $parser);
        \D::setInstance($debugger);

        // Act
        \D::enable(false);

        // Assert
        self::assertFalse(\D::getInstance()->isOn);
    }

    public function testGlobalFunctionDCallsFacadeDump(): void
    {
        // Arrange
        self::assertTrue(function_exists('d'));

        $log = $this->createMock(LogInterface::class);
        $parser = $this->createMock(ParserInterface::class);

        $parser->expects(self::once())
            ->method('parse')
            ->willReturn('parsed');

        $capturedMessage = null;
        $log->expects(self::once())
            ->method('log')
            ->willReturnCallback(static function (string $message) use (&$capturedMessage): void {
                $capturedMessage = $message;
            });

        $debugger = new Debugger($log, $parser);
        \D::setInstance($debugger);

        // Act
        d('value');

        // Assert
        self::assertIsString($capturedMessage);
        self::assertStringContainsString(__FILE__, $capturedMessage);
        self::assertStringNotContainsString('src/D.php', $capturedMessage);
    }
}
