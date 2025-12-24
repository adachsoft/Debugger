<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

use AdachSoft\Debugger\Log\LogInterface;
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
