<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AdachSoft\Debugger\DebuggerFactory;

DebuggerFactory::createTypeWithoutValue()->varDump([12, 72, 360]);
DebuggerFactory::createTypeWithoutValue()->varDump(72.12);
DebuggerFactory::createTypeWithoutValue()->varDump(null);
DebuggerFactory::createTypeWithoutValue()->varDump(2160);
DebuggerFactory::createTypeWithoutValue()->varDump('test');

DebuggerFactory::createTypeWithoutValue()->varDump('test', 432, 1.618, []);
