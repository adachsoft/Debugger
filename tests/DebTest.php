<?php

namespace Tests\AdachSoft\Debugger;

use AdachSoft\Debugger\Deb;
use AdachSoft\Debugger\Debugger;
use PHPUnit\Framework\TestCase;

class DebTest extends TestCase
{
    public function test(): void
    {
        $result = Deb::get();

        $this->assertInstanceOf(Debugger::class, $result);
    }
}
