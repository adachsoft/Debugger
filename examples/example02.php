<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AdachSoft\Debugger\Deb;

// Example 02: Error Handler

Deb::get()->setErrorHandler();

// Trigger undefined variable warning
/** @noinspection PhpUndefinedVariableInspection */
$t = $r + $b;

// Trigger undefined variable warning
/** @noinspection PhpUndefinedVariableInspection */
echo $g;
