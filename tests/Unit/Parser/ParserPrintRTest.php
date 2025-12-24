<?php

declare(strict_types=1);

namespace Tests\Unit\Parser;

use AdachSoft\Debugger\ParserPrintR;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParserPrintR::class)]
final class ParserPrintRTest extends TestCase
{
    public function testParseUsesPrintR(): void
    {
        $parser = new ParserPrintR();
        
        ob_start();
        $parser->parse(['a' => 1]);
        $output = ob_get_clean();

        $this->assertStringContainsString('[a] => 1', $output);
    }
}
