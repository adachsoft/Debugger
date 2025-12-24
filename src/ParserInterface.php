<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

interface ParserInterface
{
    /**
     * Parse the variable and return its textual representation.
     */
    public function parse(mixed $variable): string;
}
