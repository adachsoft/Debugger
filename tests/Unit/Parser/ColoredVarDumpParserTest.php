<?php

declare(strict_types=1);

namespace Tests\Unit\Parser;

use AdachSoft\Debugger\Parser\ColoredVarDumpParser;
use AdachSoft\Debugger\ParserInterface;
use AdachSoft\Debugger\VarDump\VarDumper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ColoredVarDumpParser::class)]
final class ColoredVarDumpParserTest extends TestCase
{
    public function testItImplementsParserInterface(): void
    {
        // Arrange
        $sut = new ColoredVarDumpParser(new VarDumper(colorsEnabled: true));

        // Act
        $result = $sut;

        // Assert
        self::assertInstanceOf(ParserInterface::class, $result);
    }

    public function testParseReturnsColorTaggedOutput(): void
    {
        // Arrange
        $sut = new ColoredVarDumpParser(new VarDumper(colorsEnabled: true));

        // Act
        $result = $sut->parse('test');

        // Assert
        self::assertIsString($result);
        self::assertNotSame('', $result);
        self::assertStringContainsString('<bright-magenta>', $result);
        self::assertStringContainsString('<bright-green>', $result);
    }
}
