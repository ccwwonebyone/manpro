<?php
namespace Manpro\Doc;

class Mysql
{
    protected $config = [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => '',
        'username' => '',
        'password' => '',
        // 'unix_socket' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix' => '',
        // 'strict' => false,
        'engine' => null,
    ];

    protected $pdo;

    public function __construct($config)
    {
        $this->config = array_merge($this->config, $config);
        $dsn    = $this->config['driver'].':dbname='.$this->config['database'].';host='.$this->config['host'].';port='.$this->config['port'];
        $this->pdo = new \PDO($dsn, $this->config['username'], $this->config['password']);
        $this->pdo->prepare(
            "set names '{$this->config['charset']}' collate '{$this->config['collation']}'"
        )->execute();
    }

    public function tabs()
    {
        $sql  = "show table status";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function columns($table)
    {
        $sql = 'show full columns from ' . $table;
        return $this->pdo->query($sql)->fetchAll();
    }

    public function databases()
    {
        $sql = 'show databases';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function docTable($tab)
    {
        $fields = [
            'Field'=>'字段',
            'Comment'=>'注释',
            'Type'=>'类型',
            'Null'=>'能否为null',
            'Default'=>'默认值',
            'Collation'=>'字符集',
        ];
        $content  = "---\r\n## *{$tab['Name']}-{$tab['Comment']}*\r\n";
        $content .= "```\r\n注释：{$tab['Comment']}\r\nengine：{$tab['Engine']}\r\n字符集：{$tab['Collation']}\r\n```\r\n";
        $content .= implode(' | ', $fields)."\r\n";
        $content .= implode(' | ', array_fill(0, count($fields), '---'))."\r\n";
        $columns = $this->columns($tab['Name']);
        foreach ($columns as $k => $v) {
            foreach ($fields as $key => $value) {
                $temp[$key] = $v[$key];
            }
            $content .= implode(' | ', $temp) . "\r\n";
        }
        return $content;
    }

    public function markdown($file_path = './')
    {
        $tabs = $this->tabs();
        $content = "[TOC]\r\n";
        $content .= '# '.$this->config['database']."\r\n";
        foreach ($tabs as $tab) {
            $content .= $this->docTable($tab);
        }
        file_put_contents($file_path. $this->config['database']. '.md', $content);
    }
}
