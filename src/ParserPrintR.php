<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

class ParserPrintR implements ParserInterface
{
    public function parse(mixed $variable): void
    {
        print_r($variable);
    }
}
