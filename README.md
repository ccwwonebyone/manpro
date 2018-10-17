# manpro

## traversal 遍历目录

## 生成markdown数据库文档

```
use Manpro\Manpro;

$manpro = new Manpro();

$doc_mysql = $manpro->setDocMysql([         //设置连接数据库
    'database' => 'blog',
    'username' => 'root',
    'password' => '123456',
    'charset'  => 'utf-8',
]);

$tabs = $doc_mysql->markdown($file_path='./');  //默认文当前路径
```