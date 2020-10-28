<?php

namespace AdachSoft\Debugger;

interface ParserInterface
{
    public function parse($variable): void;
}
