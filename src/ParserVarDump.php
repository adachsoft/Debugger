<?php

namespace AdachSoft\Debugger;

class ParserVarDump implements ParserInterface
{
    public function parse($variable): void
    {
        var_dump($variable);
    }
}
