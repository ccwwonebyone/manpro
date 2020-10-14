<?php

namespace Manpro;

trait ManproInstance
{
    protected static $manproInstances = [];

    /**
     * @param  mixed  ...$argc
     * @return static
     */
    public static function getSingletonInstance(...$argc)
    {
        if (!isset(static::$manproInstances[static::class])) {
            static::$manproInstances[static::class] = static::getInstance(...$argc);
        }
        return static::$manproInstances[static::class];
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
