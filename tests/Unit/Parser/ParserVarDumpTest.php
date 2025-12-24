<?php

declare(strict_types=1);

namespace Tests\Unit\Parser;

use AdachSoft\Debugger\ParserVarDump;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParserVarDump::class)]
final class ParserVarDumpTest extends TestCase
{
    public function testParseReturnsVarDumpString(): void
    {
        // Arrange
        $parser = new ParserVarDump();

        // Act
        $result = $parser->parse('test');

        // Assert
        self::assertStringContainsString('string(4) "test"', $result);
    }
}
