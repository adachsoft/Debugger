<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

use AdachSoft\Debugger\Log\LogToServer;
use AdachSoft\Debugger\Parser\ColoredVarDumpParser;
use AdachSoft\Debugger\Parser\TypeWithoutValueParser;
use AdachSoft\Debugger\VarDump\VarDumper;

/**
 * Factory for creating Debugger instances with default dependencies.
 */
final class DebuggerFactory
{
    public static function create(): Debugger
    {
        return new Debugger(new LogToServer(), new ParserVarDump());
    }

    public static function createColored(): Debugger
    {
        return new Debugger(
            new LogToServer(),
            new ColoredVarDumpParser(new VarDumper(colorsEnabled: true))
        );
    }

    public static function createTypeWithoutValue(): Debugger
    {
        return new Debugger(new LogToServer(), new TypeWithoutValueParser());
    }
}
