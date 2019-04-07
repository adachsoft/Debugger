<?php

namespace AdachSoft\Debugger;

class ParserPrintR implements ParserInterface{
    public function parse($variable)
    {
        print_r($variable);
    }
}