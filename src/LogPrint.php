<?php

namespace AdachSoft\Debugger;


class LogPrint implements LogInterface{

    public function log(string $message)
    {
        echo $message;
    }
}