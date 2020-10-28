<?php

namespace AdachSoft\Debugger\Parser;

use AdachSoft\Debugger\ParserInterface;

class TypeWithoutValueParser implements ParserInterface
{
    public function parse($variable): void
    {
        echo gettype($variable);
        if (is_object($variable)) {
            echo ':' . get_class($variable);
        }elseif(is_resource($variable)) {
            echo ':' . get_resource_type($variable);
        }elseif(is_array($variable)){
            echo ':' . count($variable);
        }elseif(is_string($variable)){
            echo ':' . strlen($variable);
        }
    }
}
