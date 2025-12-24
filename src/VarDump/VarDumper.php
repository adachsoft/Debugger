<?php

declare(strict_types=1);

namespace AdachSoft\Debugger\VarDump;

/**
 * Lightweight, deterministic variable dumper.
 *
 * When colors are enabled, it wraps parts of the output with console-io color tags
 * (e.g. <bright-cyan>, <bright-yellow>, <bright-green>, <bright-magenta>, <bright-white>),
 * which can be later rendered as ANSI escape codes by ColoredCliOutput.
 */
final class VarDumper
{
    private const INDENT = '  ';

    public function __construct(
        private readonly bool $colorsEnabled = false,
        private readonly int $maxDepth = 6
    ) {
    }

    public function dump(mixed $variable): string
    {
        return $this->dumpValue($variable, depth: 0);
    }

    private function dumpValue(mixed $value, int $depth): string
    {
        if ($depth >= $this->maxDepth) {
            return $this->style(text: '*MAX_DEPTH*', style: 'bright-white');
        }

        if ($value === null) {
            return $this->style(text: 'null', style: 'bright-white');
        }

        if (is_bool($value)) {
            return $this->style(text: $value ? 'true' : 'false', style: 'bright-yellow');
        }

        if (is_int($value)) {
            return $this->style(text: (string) $value, style: 'bright-cyan');
        }

        if (is_float($value)) {
            return $this->style(text: (string) $value, style: 'bright-cyan');
        }

        if (is_string($value)) {
            $len = strlen($value);
            $type = $this->style(text: "string({$len})", style: 'bright-magenta');
            $quoted = $this->style(text: '"' . $this->escapeString($value) . '"', style: 'bright-green');

            return $type . ' ' . $quoted;
        }

        if (is_array($value)) {
            return $this->dumpArray($value, depth: $depth);
        }

        if (is_object($value)) {
            return $this->dumpObject($value, depth: $depth);
        }

        if (is_resource($value)) {
            return $this->style(text: 'resource(' . get_resource_type($value) . ')', style: 'bright-magenta');
        }

        return $this->style(text: gettype($value), style: 'bright-magenta');
    }

    /**
     * @param array<mixed> $value
     */
    private function dumpArray(array $value, int $depth): string
    {
        $count = count($value);
        $header = $this->style(text: "array({$count})", style: 'bright-magenta');

        if ($count === 0) {
            return $header . ' []';
        }

        $indent = str_repeat(self::INDENT, $depth + 1);
        $lines = [$header . ' ['];

        foreach ($value as $key => $item) {
            $keyText = is_int($key) ? (string) $key : '"' . $this->escapeString((string) $key) . '"';
            $styledKey = $this->style(text: $keyText, style: 'bright-blue');

            $lines[] = $indent . $styledKey . ' => ' . $this->dumpValue($item, depth: $depth + 1);
        }

        $lines[] = str_repeat(self::INDENT, $depth) . ']';

        return implode(PHP_EOL, $lines);
    }

    private function dumpObject(object $value, int $depth): string
    {
        $class = $value::class;
        $header = $this->style(text: 'object(' . $class . ')', style: 'bright-magenta');

        $vars = get_object_vars($value);
        if ($vars === []) {
            return $header . ' {}';
        }

        $indent = str_repeat(self::INDENT, $depth + 1);
        $lines = [$header . ' {'];

        foreach ($vars as $name => $item) {
            $styledName = $this->style(text: (string) $name, style: 'bright-blue');
            $lines[] = $indent . $styledName . ': ' . $this->dumpValue($item, depth: $depth + 1);
        }

        $lines[] = str_repeat(self::INDENT, $depth) . '}';

        return implode(PHP_EOL, $lines);
    }

    private function escapeString(string $value): string
    {
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace('"', '\\"', $value);
        $value = str_replace("\r", "\\r", $value);
        $value = str_replace("\n", "\\n", $value);
        $value = str_replace("\t", "\\t", $value);

        return $value;
    }

    private function style(string $text, string $style): string
    {
        if (!$this->colorsEnabled) {
            return $text;
        }

        return "<{$style}>{$text}</{$style}>";
    }
}
