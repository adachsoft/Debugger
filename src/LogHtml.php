<?php

namespace AdachSoft\Debugger;

class LogHtml implements LogInterface
{
    /**
     * {@inheritDoc}
     *
     */
    public function log(string $message)
    {
        echo "<pre>".$message."</pre>";
    }
}
