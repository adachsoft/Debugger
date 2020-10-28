<?php

namespace Tests\AdachSoft\Debugger\Parser;

use AdachSoft\Debugger\Parser\TypeWithoutValueParser;
use AdachSoft\Debugger\ParserInterface;
use PHPUnit\Framework\TestCase;

class TypeWithoutValueParserTest extends TestCase
{
    private static $fp;

    public function testInstance(): void
    {
        $parser = new TypeWithoutValueParser();
        $this->assertInstanceOf(ParserInterface::class, $parser);
    }

    /**
     * @dataProvider dataParse
     */
    public function testParse(string $expected, $variable): void
    {
        $parser = new TypeWithoutValueParser();
        $parser->parse($variable);

        $this->expectOutputString($expected);
    }

    public function dataParse(): array
    {
        static::$fp = fopen("foo", "w");
        return [
            ['string:4', 'test'],
            ['integer', 112],
            ['NULL', null],
            ['integer', 0],
            ['double', 0.0],
            ['string:1', '0'],
            ['string:0', ''],
            ['array:3', [12, 72, 360]],
            ['array:0', []],
            ['object:AdachSoft\Debugger\Parser\TypeWithoutValueParser', new TypeWithoutValueParser()],
            ['boolean', false],
            ['double', 1.618],
            ['object:Closure', function(){}],
            ['resource:stream', static::$fp],
        ];
    }

    public static function tearDownAfterClass(): void
    {
        if (null !== static::$fp) {
            fclose(static::$fp);
        }

        if (file_exists('foo')) {
            unlink('foo');
        }
    }
}
