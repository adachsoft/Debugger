<?php

declare(strict_types=1);

namespace Tests\Unit\Log;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogToFile;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LogToFile::class)]
final class LogToFileTest extends TestCase
{
    private string $file = 'test_log.txt';

    protected function setUp(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    protected function tearDown(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    public function testItImplementsLogInterface(): void
    {
        // Arrange
        $sut = new LogToFile();

        // Act
        $result = $sut;

        // Assert
        $this->assertInstanceOf(LogInterface::class, $result);
    }

    public function testLogAppendsToFile(): void
    {
        // Arrange
        $sut = new LogToFile($this->file);

        // Act
        $sut->log('Line1');
        $sut->log('Line2');

        // Assert
        $this->assertFileExists($this->file);
        $this->assertStringEqualsFile($this->file, 'Line1Line2');
    }
}
