<?php

namespace Tests\AdachSoft\Debugger\Log;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogToServer;
use PHPUnit\Framework\TestCase;

class LogToServerTest extends TestCase
{
    public function testInstance(): void
    {
        $log = new LogToServer();

        $this->assertInstanceOf(LogInterface::class, $log);
    }
}
