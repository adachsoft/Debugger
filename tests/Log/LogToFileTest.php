<?php

namespace Tests\AdachSoft\Debugger\LogPrint;

use AdachSoft\Debugger\Log\LogInterface;
use AdachSoft\Debugger\Log\LogToFile;
use PHPUnit\Framework\TestCase;

class LogToFileTest extends TestCase
{
    private const FILE_NAME = 'log.txt';

    public function testInstance(): void
    {
        $log = new LogToFile();

        $this->assertInstanceOf(LogInterface::class, $log);
    }

    public function testLog(): void
    {
        $this->assertFileDoesNotExist(static::FILE_NAME);

        $log = new LogToFile();
        $log->fileName = static::FILE_NAME;
        $log->log('test');

        $this->assertFileExists(static::FILE_NAME);
        $this->assertSame('test', file_get_contents(static::FILE_NAME));
    }

    public static function tearDownAfterClass(): void
    {
        if (file_exists(static::FILE_NAME)) {
            unlink(static::FILE_NAME);
        }
    }
}
