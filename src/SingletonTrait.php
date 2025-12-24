<?php

declare(strict_types=1);

namespace AdachSoft\Debugger;

use LogicException;

/**
 * Define singleton trait.
 */
trait SingletonTrait
{
    /**
     * Singleton object.
     */
    private static ?self $singleton = null;

    /**
     * Hide constructor.
     */
    private function __construct()
    {
    }

    /**
     * Prevent cloning of the instance.
     */
    protected function __clone()
    {
    }

    /**
     * Prevent serialization of the instance.
     */
    public function __serialize(): array
    {
        throw new LogicException('Cannot serialize a singleton.');
    }

    /**
     * Prevent deserialization of the instance.
     */
    public function __unserialize(array $data): void
    {
        throw new LogicException('Cannot unserialize a singleton.');
    }

    /**
     * Get an instance of the class.
     */
    public static function getInstance(): static
    {
        if (null === self::$singleton) {
            self::$singleton = new static();
        }

        return self::$singleton;
    }

    public static function clearInstance(): void
    {
        self::$singleton = null;
    }
}
