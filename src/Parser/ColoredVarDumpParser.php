<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\Parser;

use AdachSoft\Debugger\ParserInterface;
use AdachSoft\Debugger\VarDump\VarDumper;

/**
 * Parser that uses the custom VarDumper.
 */
final class ColoredVarDumpParser implements ParserInterface
{
    public function __construct(
        private readonly VarDumper $varDumper
    ) {
    }

    public function parse(mixed $variable): string
    {
        return $this->varDumper->dump($variable);
    }
}
