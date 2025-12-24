<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Example 06: Global facade usage (D::*) and global helper function d()

$payload = [
    'string' => 'hello',
    'int' => 123,
    'float' => 1.618,
    'nested' => ['a' => 1, 'b' => [true, null]],
];

// Default instance (colored)
d($payload);

// Switch formatting to "type only" for large structures
D::useTypeOnly();
d($payload);

// Back to standard output
D::useStandard();
D::dump('standard mode', $payload);

// Simple timing
D::start();
usleep(100_000);
$elapsed = D::stop('sleep');
D::dump('elapsed', $elapsed);

// Stack trace
D::trace();
