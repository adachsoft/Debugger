<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

final class ParserVarDump implements ParserInterface
{
    public function parse(mixed $variable): string
    {
        ob_start();
        var_dump($variable);

        $dump = ob_get_clean();

        return false === $dump ? '' : $dump;
    }
}
