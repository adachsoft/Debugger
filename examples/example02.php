<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AdachSoft\Debugger\DebuggerFactory;

// Example 02: Error Handler

DebuggerFactory::create()->setErrorHandler();

// Trigger undefined variable warning
/** @noinspection PhpUndefinedVariableInspection */
$t = $r + $b;

// Trigger undefined variable warning
/** @noinspection PhpUndefinedVariableInspection */
echo $g;
