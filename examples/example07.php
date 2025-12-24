<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Example 07: Explicitly enable colored output via facade

D::useColored();

d('colored mode (explicit)');
d([
    'a' => 1,
    'b' => [true, null, 'x' => "line\nwith\nnewlines"],
]);

D::dump('also works via D::dump()', 123, 1.618);
