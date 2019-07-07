<?php
namespace Manpro\Tools;

use Manpro\ManproException;

class Time extends Tool
{
    /**
     * 获取Unix毫秒时间戳
     * @return float Unix毫秒时间戳
     */
    public function msectime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (int)$sec.str_pad((int)($msec*1000), 3, "0", STR_PAD_LEFT);
    }

    /**
     * 获取两个日期之间的所有间隔数据 包含自身
     * @param  Date $smallDate 较小的日期
     * @param  Date $bigDate   较大的日期
     * @param  string $format  生成日期的格式
     * @param  string $interval 间隔
     * @return array
     */
    public function betweenDates($smallDate, $bigDate, $format = 'Y-m-d', $interval = '+1 days')
    {
        $time1 = strtotime($smallDate); // 自动为00:00:00 时分秒 两个时间之间的年和月份
        $time2 = strtotime($bigDate);
        $datearr = array();
        $datearr[] = date($format, $time1);
        while (($time1 = strtotime($interval, $time1)) <= $time2) {
            $datearr[] = date($format, $time1); // 取得递增月;
        }
        $datearr[] = date($format, $time2);
        return array_unique($datearr);
    }
}