<?php

namespace AdachSoft\Debugger;

class ParserPrintR implements ParserInterface
{
    public function parse($variable): void
    {
        print_r($variable);
    }
}
