<?php
namespace Manpro\Tools;

use Manpro\ManproException;

class File extends Tool
{
    /**
    * 遍历目录
    * @param  string $dir 目录路径
    * @param  function $fun 闭包函数
    * @return void
    */
    public function traversal($dir, $fun)
    {
        if (!is_dir($dir)) {
            throw new ManproException($dir.'不是目录');
        }
        $dh = opendir($dir);
        if (!$dh) {
            throw new ManproException("打开{$dir}失败");
        }
        while (($file = readdir($dh)) !== false) {
            if ($file == '..' || $file == '.') {
                continue;
            }
            $next = substr($dir, -1) == '/' ? $dir . $file : $dir . '/' . $file;
            if (is_dir($next)) {
                $this->traversal($next, $fun);
                $fun($dir, $file, 1);
            } else {
                $fun($dir, $file, 2);
            }
        }
        closedir($dh);
    }
}
