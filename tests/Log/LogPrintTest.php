<?php

namespace Tests\AdachSoft\Debugger\LogPrint;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogPrint;
use PHPUnit\Framework\TestCase;

class LogPrintTest extends TestCase
{
    public function testInstance(): void
    {
        $log = new LogPrint();

        $this->assertInstanceOf(LogInterface::class, $log);
    }

    public function testLog(): void
    {
        $log = new LogPrint();
        $log->log('test');

        $this->expectOutputString('test');
    }
}
