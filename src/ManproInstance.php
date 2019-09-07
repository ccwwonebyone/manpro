<?php
namespace Manpro;

trait ManproInstance
{
    protected static $manpro_instance = [];

    public static function getSingletonInstance(...$argc)
    {
        if (!isset(static::$manpro_instance[static::class])) {
            static::$manpro_instance[static::class] = new static(...$argc);
        }
        return static::$manpro_instance[static::class];
    }

    public static function getInstance(...$argc)
    {
        return new static(...$argc);
    }
}
