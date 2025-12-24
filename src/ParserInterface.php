<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

interface ParserInterface
{
    public function parse(mixed $variable): void;
}
