<?php

namespace AdachSoft\Debugger;

/**
 * Define singleton trait.
 */
trait SingletonTrait
{
    /**
    * Singleton object.
    */
    private static $singleton;

    /**
     * Hide constructor.
     */
    private function __construct()
    {
    }
    
    /**
     * Prevent cloning of the instance.
     *
     * @return void
     */
    protected function __clone()
    {
    }

    /**
     * Prevent serialization of the instance.
     *
     * @return array
     */
    protected function __sleep()
    {
    }

    /**
     * Prevent deserialization of the instance.
     */
    protected function __wakeup()
    {
    }

    /**
     * Get an instance of the class.
     */
    public static function getInstance()
    {
        if (null === self::$singleton) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    public static function clearInstance(): void
    {
        self::$singleton = null;
    }
}
