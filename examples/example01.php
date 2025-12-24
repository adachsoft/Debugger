<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AdachSoft\Debugger\DebuggerFactory;

// Example 01: Basic usage with DebuggerFactory

$deb = DebuggerFactory::create();
$arr = ['abc', 123, 88 => false];
$arr['#'] = [1, 2, 3, 'ABC', 'key' => 0.56];

$deb->varDump('gfgdgf', $arr);

$deb->startTime();
sleep(1);
$deb->stopTime();

DebuggerFactory::create()->varDump(1.618, true, 'QWERTY');
