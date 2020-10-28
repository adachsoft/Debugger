<?php

namespace Tests\AdachSoft\Debugger\Debugger;

use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\ParserInterface;
use PHPUnit\Framework\TestCase;

class DebuggerTest extends TestCase
{
    public function test(): void
    {
        $log = $this->createMock(LogInterface::class);
        $parser = $this->createMock(ParserInterface::class);

        $log->expects($this->once())->method('log');

        Debugger::clearInstance();
        $debugger = Debugger::getInstance($log, $parser);
        $debugger->varDump('test');
    }
}
