<?php

declare(strict_types=1);

namespace Tests\Unit\VarDump;

use AdachSoft\Debugger\VarDump\VarDumper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VarDumper::class)]
final class VarDumperTest extends TestCase
{
    public function testDumpWithoutColorsDoesNotContainTags(): void
    {
        // Arrange
        $sut = new VarDumper(colorsEnabled: false);

        // Act
        $result = $sut->dump(['a' => 'test']);

        // Assert
        self::assertIsString($result);
        self::assertNotSame('', $result);
        self::assertStringNotContainsString('<bright-magenta>', $result);
        self::assertStringNotContainsString('<bright-green>', $result);
    }

    public function testDumpWithColorsContainsColorTags(): void
    {
        // Arrange
        $sut = new VarDumper(colorsEnabled: true);

        // Act
        $result = $sut->dump('test');

        // Assert
        self::assertIsString($result);
        self::assertStringContainsString('<bright-magenta>', $result);
        self::assertStringContainsString('<bright-green>', $result);
    }
}
