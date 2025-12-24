<?php

declare(strict_types=1);

namespace Tests\Unit;

use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\DebuggerFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DebuggerFactory::class)]
final class DebuggerFactoryTest extends TestCase
{
    #[DataProvider('provideFactoryMethods')]
    public function testFactoryReturnsDebuggerInstance(string $method): void
    {
        // Arrange

        // Act
        /** @var Debugger $result */
        $result = DebuggerFactory::{$method}();

        // Assert
        self::assertInstanceOf(Debugger::class, $result);
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function provideFactoryMethods(): array
    {
        return [
            'create' => ['create'],
            'createColored' => ['createColored'],
            'createTypeWithoutValue' => ['createTypeWithoutValue'],
        ];
    }
}
