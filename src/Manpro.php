<?php
namespace Manpro;

class Manpro
{
    /**
     * 遍历目录
     * @param  string $dir 目录路径
     * @param  function $fun 闭包函数
     * @return void
     */
    public function traversal($dir, $fun)
    {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if($file == '..' || $file == '.') continue;
                    $next = substr($dir, -1) == '/' ? $dir . $file : $dir . '/' . $file;
                    if(is_dir($next)){
                        $this->traversal($next, $fun);
                        $fun($next, 1);
                    }else{
                        $fun($next, 0);
                    }
                }
                closedir($dh);
            }
        }
    }
}