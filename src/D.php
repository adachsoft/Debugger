<?php

declare(strict_types=1);

use AdachSoft\Debugger\Debugger;
use AdachSoft\Debugger\DebuggerFactory;

/**
 * Global facade for fast debugging.
 *
 * This class is intentionally declared in the global namespace (no namespace).
 */
final class D
{
    private static ?Debugger $instance = null;

    public static function getInstance(): Debugger
    {
        if (null === self::$instance) {
            self::useColored();
        }

        /** @var Debugger $instance */
        $instance = self::$instance;

        return $instance;
    }

    /**
     * Reset facade state.
     *
     * @internal
     */
    public static function reset(): void
    {
        self::$instance = null;
    }

    public static function useStandard(): void
    {
        self::$instance = DebuggerFactory::create();
    }

    public static function useColored(): void
    {
        self::$instance = DebuggerFactory::createColored();
    }

    public static function useTypeOnly(): void
    {
        self::$instance = DebuggerFactory::createTypeWithoutValue();
    }

    public static function setInstance(Debugger $debugger): void
    {
        self::$instance = $debugger;
    }

    public static function dump(mixed ...$vars): void
    {
        self::getInstance()->varDump(...$vars);
    }

    public static function trace(bool $reverse = false, ?int $limit = null): void
    {
        self::getInstance()->backTrace(reverse: $reverse, limit: $limit);
    }

    public static function start(): void
    {
        self::getInstance()->startTime();
    }

    public static function stop(string $label = ''): float
    {
        return self::getInstance()->stopTime(label: $label);
    }

    public static function enable(bool $isOn): void
    {
        self::getInstance()->isOn = $isOn;
    }
}

if (!function_exists('d')) {
    /**
     * Global helper shortcut for D::dump().
     */
    function d(mixed ...$vars): void
    {
        D::dump(...$vars);
    }
}
