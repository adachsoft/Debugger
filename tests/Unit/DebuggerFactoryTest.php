<?php

declare(strict_types=1);

namespace Tests\Unit;

use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\DebuggerFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DebuggerFactory::class)]
final class DebuggerFactoryTest extends TestCase
{
    public function testCreateReturnsDebuggerInstance(): void
    {
        // Arrange

        // Act
        $result = DebuggerFactory::create();

        // Assert
        self::assertInstanceOf(Debugger::class, $result);
    }

    public function testCreateTypeWithoutValueReturnsDebuggerInstance(): void
    {
        // Arrange

        // Act
        $result = DebuggerFactory::createTypeWithoutValue();

        // Assert
        self::assertInstanceOf(Debugger::class, $result);
    }
}
