<?php

declare(strict_types=1);

namespace Tests\Unit;

use AdachSoft\Debugger\Deb;
use AdachSoft\Debugger\Debugger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Deb::class)]
final class DebTest extends TestCase
{
    public function testGetReturnsDebuggerInstance(): void
    {
        $this->assertInstanceOf(Debugger::class, Deb::get());
    }

    public function testGetTypeWithoutValueReturnsDebuggerInstance(): void
    {
        $this->assertInstanceOf(Debugger::class, Deb::getTypeWithoutValue());
    }
}
