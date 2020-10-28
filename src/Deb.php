<?php

namespace AdachSoft\Debugger;

use AdachSoft\Debugger\Log\LogToServer;
use AdachSoft\Debugger\Parser\TypeWithoutValueParser;

class Deb
{
    /**
     * Get instance.
     *
     * @return Debugger
     */
    public static function get(): Debugger
    {
        return Debugger::getInstance(new LogToServer(), new ParserVarDump());
    }

    public static function getTypeWithoutValue(): Debugger
    {
        return Debugger::getInstance(new LogToServer(), new TypeWithoutValueParser());
    }
}
