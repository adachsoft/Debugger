<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AdachSoft\Debugger\DebuggerFactory;

$deb = DebuggerFactory::createColored();

$deb->varDump(
    'test',
    123,
    1.618,
    ['a' => 1, 'b' => [true, null, 'x' => "line\nwith\nnewlines"]]
);
