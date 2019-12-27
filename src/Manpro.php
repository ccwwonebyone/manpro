<?php
namespace Manpro;

use Manpro\Doc\Mysql;
use Manpro\Request\Client;

class Manpro
{
    use ManproInstance;

    /**
     * 容器数组
     * @var array
     */
    public static $containers = [];

    public static function setDocMysql($config)
    {
        return new Mysql($config);
    }

    public static function request($url, $headers)
    {
        return new Client($url, $headers);
    }
}
