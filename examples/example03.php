<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AdachSoft\Debugger\DebuggerFactory;

test1();

function test1(): void
{
    test2();
}

function test2(): void
{
    test3();
}

function test3(): void
{
    DebuggerFactory::create()->backTrace();
}
