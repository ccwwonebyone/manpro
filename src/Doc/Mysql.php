<?php

namespace Manpro\Doc;

class Mysql
{
    /**
     * @var array
     */
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

    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct($config)
    {
        $this->config = array_merge($this->config, $config);
        $dsn = $this->config['driver'].':dbname='.$this->config['database'].';host='.$this->config['host'].';port='.$this->config['port'];
        $this->pdo = new \PDO($dsn, $this->config['username'], $this->config['password']);
        $this->pdo->prepare(
            "set names '{$this->config['charset']}' collate '{$this->config['collation']}'"
        )->execute();
    }

    /**
     * 获取所有表格
     * @return array
     */
    public function tabs()
    {
        $sql = 'show table status';
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * 获取表格的所有字段
     * @param  string $table 表名
     * @return array
     */
    public function columns($table)
    {
        $sql = 'show full columns from '.$table;
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * 主机中的所有数据库
     * @return array
     */
    public function databases()
    {
        $sql = 'show databases';
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * 每张表生成table
     * @param  string $tab 表名
     * @return string
     */
    public function docTable($tab)
    {
        $fields = [
            'Field' => '字段',
            'Comment' => '注释',
            'Type' => '类型',
            'Null' => '能否为null',
            'Default' => '默认值',
            'Collation' => '字符集',
        ];
        $content = "---\r\n## *{$tab['Name']}-{$tab['Comment']}*\r\n";
        $content .= "```\r\n注释：{$tab['Comment']}\r\nengine：{$tab['Engine']}\r\n字符集：{$tab['Collation']}\r\n```\r\n";
        $content .= implode(' | ', $fields)."\r\n";
        $content .= implode(' | ', array_fill(0, count($fields), '---'))."\r\n";
        $columns = $this->columns($tab['Name']);
        foreach ($columns as $k => $v) {
            foreach ($fields as $key => $value) {
                $temp[$key] = $v[$key];
            }
            $content .= implode(' | ', $temp)."\r\n";
        }
        return $content;
    }

    /**
     * 生成markdown
     *
     * @param  string $filePath  生成路径
     * @return void
     */
    public function markdown($filePath = './')
    {
        $tabs = $this->tabs();
        $content = "[TOC]\r\n";
        $content .= '# '.$this->config['database']."\r\n";
        foreach ($tabs as $tab) {
            $content .= $this->docTable($tab);
        }
        file_put_contents($filePath.$this->config['database'].'.md', $content);
    }
}
