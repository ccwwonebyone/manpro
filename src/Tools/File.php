<?php
namespace Manpro\Tools;

use Closure;
use Manpro\ManproException;

class File
{
    /**
     * 遍历目录
     * @param  string  $dir  目录路径
     * @param  Closure  $fun  闭包函数
     * @return void
     * @throws ManproException
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
