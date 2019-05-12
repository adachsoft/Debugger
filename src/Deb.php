<?php

namespace AdachSoft\Debugger;

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
    
}
