<?php

namespace Tests\AdachSoft\Debugger\LogPrint;

use AdachSoft\Debugger\Log\LogHtml;
use AdachSoft\Debugger\Log\LogInterface;
use PHPUnit\Framework\TestCase;

class LogHtmlTest extends TestCase
{
    public function testInstance(): void
    {
        $log = new LogHtml();

        $this->assertInstanceOf(LogInterface::class, $log);
    }

    public function testLog(): void
    {
        $log = new LogHtml();
        $log->log('test');

        $this->expectOutputString('<pre>test</pre>');
    }
}
