<?php

namespace Manpro;

trait ManproInstance
{
    protected static $manpro_instance = [];

    /**
     * @param  mixed  ...$argc
     * @return static
     */
    public static function getSingletonInstance(...$argc)
    {
        if (!isset(static::$manpro_instance[static::class])) {
            static::$manpro_instance[static::class] = new static(...$argc);
        }
        return static::$manpro_instance[static::class];
    }

    /**
     * @param  mixed  ...$argc
     * @return static
     */
    public static function getInstance(...$argc)
    {
        return new static(...$argc);
    }
}
