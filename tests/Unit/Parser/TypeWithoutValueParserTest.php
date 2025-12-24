<?php

declare(strict_types=1);

namespace Tests\Unit\Parser;

use AdachSoft\Debugger\Parser\TypeWithoutValueParser;
use AdachSoft\Debugger\ParserInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypeWithoutValueParser::class)]
final class TypeWithoutValueParserTest extends TestCase
{
    public function testItImplementsParserInterface(): void
    {
        // Arrange
        $sut = new TypeWithoutValueParser();

        // Act
        $result = $sut;

        // Assert
        self::assertInstanceOf(ParserInterface::class, $result);
    }

    #[DataProvider('provideParseCases')]
    public function testParseReturnsTypeInformation(string $expected, mixed $value): void
    {
        // Arrange
        $sut = new TypeWithoutValueParser();

        if (is_array($value) && array_key_exists('__factory__', $value)) {
            /** @var callable(): mixed $factory */
            $factory = $value['__factory__'];
            $value = $factory();
        }

        // Act
        $result = $sut->parse($value);

        // Assert
        self::assertSame($expected, $result);

        if (is_resource($value)) {
            fclose($value);
        }
    }

    /**
     * @return array<string, array{0: string, 1: mixed}>
     */
    public static function provideParseCases(): array
    {
        return [
            'string returns length' => ['string:4', 'test'],
            'integer returns type' => ['integer', 112],
            'null returns type' => ['NULL', null],
            'integer zero returns type' => ['integer', 0],
            'double zero returns type' => ['double', 0.0],
            'string zero returns length' => ['string:1', '0'],
            'empty string returns length' => ['string:0', ''],
            'array returns count' => ['array:3', [12, 72, 360]],
            'empty array returns count' => ['array:0', []],
            'object returns class name' => [
                'object:AdachSoft\\Debugger\\Parser\\TypeWithoutValueParser',
                new TypeWithoutValueParser(),
            ],
            'boolean returns type' => ['boolean', false],
            'double returns type' => ['double', 1.618],
            'closure returns class name' => ['object:Closure', static function (): void {
            }],
            'resource returns resource type' => [
                'resource:stream',
                ['__factory__' => static fn (): mixed => fopen('php://memory', 'w')],
            ],
        ];
    }
}
