<?php

namespace AdachSoft\Debugger;

class ParserVarDump implements ParserInterface
{
    public function parse($variable)
    {
        var_dump($variable);
    }
}
