<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

final class ParserPrintR implements ParserInterface
{
    public function parse(mixed $variable): string
    {
        return print_r($variable, true);
    }
}
