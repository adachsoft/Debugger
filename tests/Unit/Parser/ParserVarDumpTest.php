<?php

declare(strict_types=1);

namespace Tests\Unit\Parser;

use AdachSoft\Debugger\ParserVarDump;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParserVarDump::class)]
final class ParserVarDumpTest extends TestCase
{
    public function testParseUsesVarDump(): void
    {
        $parser = new ParserVarDump();
        
        ob_start();
        $parser->parse('test');
        $output = ob_get_clean();

        $this->assertStringContainsString('string(4) "test"', $output);
    }
}
