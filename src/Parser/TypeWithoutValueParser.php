<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Parser;

use AdachSoft\Debugger\ParserInterface;

final class TypeWithoutValueParser implements ParserInterface
{
    public function parse(mixed $variable): string
    {
        $result = gettype($variable);

        if (is_object($variable)) {
            $result .= ':' . get_class($variable);

            return $result;
        }

        if (is_resource($variable)) {
            $result .= ':' . get_resource_type($variable);

            return $result;
        }

        if (is_array($variable)) {
            $result .= ':' . count($variable);

            return $result;
        }

        if (is_string($variable)) {
            $result .= ':' . strlen($variable);

            return $result;
        }

        return $result;
    }
}
