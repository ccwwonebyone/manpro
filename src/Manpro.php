<?php
namespace Manpro;

use Manpro\Doc\Mysql;
use Manpro\Request\Client;
use Manpro\Request\Tool;

class Manpro
{
    const $tool;

    public static function setDocMysql($config)
    {
        self::$doc_mysql = new Mysql($config);
        return self::$doc_mysql;
    }

    
    public static function request($url, $headers)
    {
        return new Client($url, $headers);
    }

    public static function tool()
    {
        if(!static::$tool){
            static::$tool = new Tool();
        }
        return static::$tool;
    }
}
