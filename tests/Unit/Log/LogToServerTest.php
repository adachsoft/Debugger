<?php

declare(strict_types=1);

namespace Tests\Unit\Log;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogToServer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LogToServer::class)]
final class LogToServerTest extends TestCase
{
    public function testItImplementsLogInterface(): void
    {
        // Arrange
        $sut = new LogToServer();

        // Act
        $result = $sut;

        // Assert
        $this->assertInstanceOf(LogInterface::class, $result);
    }

    public function testDefaultConfiguration(): void
    {
        // Arrange
        $sut = new LogToServer();

        // Act
        $host = $sut->host;
        $port = $sut->port;

        // Assert
        $this->assertSame('127.0.0.1', $host);
        $this->assertSame(2160, $port);
    }
}
