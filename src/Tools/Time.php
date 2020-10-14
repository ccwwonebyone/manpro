<?php

namespace Manpro\Tools;

class Time
{
    /**
     * 获取Unix毫秒时间戳
     * @return float Unix毫秒时间戳
     */
    public function millisecond()
    {
        list($millisecond, $sec) = explode(' ', microtime());
        return (int) $sec.str_pad((int) ($millisecond * 1000), 3, '0', STR_PAD_LEFT);
    }

    /**
     * 获取两个日期之间的所有间隔数据 包含自身
     * @param  string  $smallDate  较小的日期
     * @param  string  $bigDate  较大的日期
     * @param  string  $format  生成日期的格式
     * @param  string  $interval  间隔
     * @return array
     */
    public function betweenDates($smallDate, $bigDate, $format = 'Y-m-d', $interval = '+1 days')
    {
        $time1 = strtotime($smallDate); // 自动为00:00:00 时分秒 两个时间之间的年和月份
        $time2 = strtotime($bigDate);
        $dates = [];
        $dates[] = date($format, $time1);
        while (($time1 = strtotime($interval, $time1)) <= $time2) {
            $dates[] = date($format, $time1); // 取得递增月;
        }
        $dates[] = date($format, $time2);
        return array_unique($dates);
    }

    /**
     * 获取两个时间的间隔天数
     *
     * @param $start_date
     * @param $end_date
     * @return int
     */
    public function twoDateDays($startDate, $endDate): int
    {
        return (strtotime($endDate) - strtotime($startDate)) / (24 * 60 * 60);
    }

    /**
     * 获取完整月份日期
     *
     * @param $start_date
     * @param  $end_date
     * @return array
     */
    public function getFullMonthDate($startDate, $endDate)
    {
        //TODO:  获取完整月份日期
        //如果开始时间是月初，结束时间是月末
        if ($this->isMonthStart($startDate) && $this->isMonthEnd($endDate)) {
            return ['nature_date' => [$startDate, $endDate]];
        }
        //如果是同一个月
        if (!$this->isSameMoth($startDate, $endDate)) {
            $returnDate = [];
            $nextMonthStart = date('Y-m-01', strtotime('first day of +1 month', strtotime($startDate)));
            $lastMonthEnd = date('Y-m-t', strtotime('last day of -1 month', strtotime($endDate)));
            if ($nextMonthStart < $lastMonthEnd) {
                $returnDate['nature_date'][] = [$nextMonthStart, $lastMonthEnd];
            }
            //如果是月初
            if ($this->isMonthStart($startDate)) {
                $returnDate['nature_date'][] = [$startDate, $this->monthEnd($startDate)];
            }
            //如果是月末
            if ($this->isMonthEnd($endDate)) {
                $returnDate['nature_date'][] = [$this->monthStart($endDate), $endDate];
            }
            return $returnDate;
        }
    }

    /**
     * 获取不完整月份日期
     *
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public function getNotFullMonthDate($start_date, $end_date)
    {
        //TODO: 获取不完整月份日期
    }

    public function diffDate($start_date, $end_date, $format = 'Y-m-d H:i:s')
    {
    }

    /**
     * 是否是月末
     * @param $date
     * @return bool
     */
    public function isMonthEnd($date): bool
    {
        return $this->monthEnd($date) == $date;
    }

    /**
     * 是否是月初
     * @param $date
     * @return bool
     */
    public function isMonthStart($date): bool
    {
        return $this->monthStart($date) == $date;
    }

    /**
     * 是否是同月
     * @param $start_date
     * @param $end_date
     * @return bool
     */
    public function isSameMoth($startDate, $endDate): bool
    {
        return date('Y-m', strtotime($startDate)) == date('Y-m', strtotime($endDate));
    }

    /**
     *月末
     * @param $date
     * @return false|string
     */
    public function monthEnd($date): string
    {
        return date('Y-m-t', strtotime($date));
    }

    /**
     * 月初
     * @param $date
     * @return false|string
     */
    public function monthStart($date): string
    {
        return date('Y-m-01', strtotime($date));
    }
}
