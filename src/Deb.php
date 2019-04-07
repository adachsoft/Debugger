<?php

namespace AdachSoft\Debugger;

class Deb
{
    public static function get()
    {
        return Debugger::getInstance(new LogToServer(), new ParserVarDump());
    }
}
