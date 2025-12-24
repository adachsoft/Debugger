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
        $this->assertInstanceOf(ParserInterface::class, $result);
    }

    #[DataProvider('provideParseCases')]
    public function testParsePrintsTypeInformation(string $expected, mixed $value): void
    {
        // Arrange
        $sut = new TypeWithoutValueParser();

        if (is_array($value) && array_key_exists('__factory__', $value)) {
            /** @var callable(): mixed $factory */
            $factory = $value['__factory__'];
            $value = $factory();
        }

        $this->expectOutputString($expected);

        // Act
        $sut->parse($value);

        // Assert
        // Assertions are performed by expectOutputString().

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
            'string prints length' => ['string:4', 'test'],
            'integer prints type' => ['integer', 112],
            'null prints type' => ['NULL', null],
            'integer zero prints type' => ['integer', 0],
            'double zero prints type' => ['double', 0.0],
            'string zero prints length' => ['string:1', '0'],
            'empty string prints length' => ['string:0', ''],
            'array prints count' => ['array:3', [12, 72, 360]],
            'empty array prints count' => ['array:0', []],
            'object prints class name' => [
                'object:AdachSoft\\Debugger\\Parser\\TypeWithoutValueParser',
                new TypeWithoutValueParser(),
            ],
            'boolean prints type' => ['boolean', false],
            'double prints type' => ['double', 1.618],
            'closure prints class name' => ['object:Closure', static function (): void {
            }],
            'resource prints resource type' => [
                'resource:stream',
                ['__factory__' => static fn (): mixed => fopen('php://memory', 'w')],
            ],
        ];
    }
}
