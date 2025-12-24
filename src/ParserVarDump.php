<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

class ParserVarDump implements ParserInterface
{
    public function parse(mixed $variable): void
    {
        var_dump($variable);
    }
}
