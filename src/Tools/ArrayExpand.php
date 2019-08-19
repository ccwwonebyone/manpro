<?php
namespace Manpro\Tools;

use Manpro\ManproException;

class ArrayExpand extends Tool
{
    /**
    * 将数组中的一列值作为键值
    * @param  array $data 数组
    * @param  string $key 键名
    * @return array
    */
    public function ArrColumnToKey($data, $key)
    {
        return array_combine(array_column($data, $key), $data);
    }
}
