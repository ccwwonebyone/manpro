<?php
namespace Manpro;

use Manpro\Doc\Mysql;
use Manpro\Request\Client;
use Manpro\Request\Tool;

class Manpro
{
    /**
     * 容器数组
     * @var array
     */
    static $containers = [];

    public static function setDocMysql($config)
    {
        return new Mysql($config);
    }

    public static function request($url, $headers)
    {
        return new Client($url, $headers);
    }

    public static function tool()
    {
        if(!static::$containers['tool']){
            static::$containers['tool'] = new Tool();
        }
        return static::$containers['tool'];
    }
}
