<?php
namespace Manpro\Doc;

class Mysql
{
    protected $config = [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        // 'port' => '3306',
        'database' => '',
        'username' => '',
        'password' => '',
        // 'unix_socket' => '',
        // 'charset' => 'utf8',
        // 'collation' => 'utf8_general_ci',
        // 'prefix' => '',
        // 'strict' => false,
        // 'engine' => null,
    ];

    protected $pdo;

    public function __construct($config)
    {
        $config = array_merge($this->config, $config);
        $dsn    = $config['driver'].':dbname='.$config['database'].';host='.$config['host'];
        $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
    }

    public function tabs()
    {
        $sql  = "show table status";
        return $this->pdo->query($sql)->fetchAll();
    }

}