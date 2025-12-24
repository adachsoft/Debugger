<?php

declare(strict_types=1);

namespace Tests\Unit\Parser;

use AdachSoft\Debugger\ParserPrintR;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParserPrintR::class)]
final class ParserPrintRTest extends TestCase
{
    public function testParseReturnsPrintRString(): void
    {
        // Arrange
        $parser = new ParserPrintR();

        // Act
        $result = $parser->parse(['a' => 1]);

        // Assert
        self::assertStringContainsString('[a] => 1', $result);
    }
}
