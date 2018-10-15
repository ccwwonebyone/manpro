<?php
namespace Manpro;

use Manpro\Doc\Mysql;

class Manpro
{
    protected $doc_mysql;

    public function setDocMysql($config)
    {
        $this->doc_mysql = new Mysql($config);
        return $this->doc_mysql;
    }

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
                        $fun($dir, $file, 1);
                    }else{
                        $fun($dir, $file, 2);
                    }
                }
                closedir($dh);
            }
        }
    }

    /**获取Unix毫秒时间戳
     * @return float Unix毫秒时间戳
     */
    public function msectime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (int)$sec.str_pad((int)($msec*1000),3,"0",STR_PAD_LEFT);
    }

    /**
     * 解析最小代码
     * ['1215','121516','121416','12141617']  返回 ['1215','121416']
     * @param  array $areacodes 部门代码
     * @return array            解析出最顶级的部门代码
     */
    public function parseCode($areacodes)
    {
        $minLength = strlen(reset($areacodes));
        $searchArr = array(current($areacodes));
        foreach ($areacodes as $value) {
            if($minLength < strlen($value)) continue;
            if($minLength > strlen($value)){
                $minLength = strlen($value);
                $searchArr = array();
                $searchArr[] = $value;
            }
            if($minLength == strlen($value)) $searchArr[] = $value;
        }
        $searchArr = array_unique($searchArr);
        $checkAreacode = array_diff($areacodes,$searchArr);
        foreach ($checkAreacode as $key => $value) {
            foreach ($searchArr as $val) {
                if(strpos($value,$val) === 0) unset($checkAreacode[$key]);
            }
        }
        if(!empty($checkAreacode)) $searchArr = array_merge($searchArr,$this->parseCode($checkAreacode));
        return $searchArr;
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
        $datearr[] = date($format,$time1);
        while( ($time1 = strtotime($interval, $time1)) <= $time2){
              $datearr[] = date($format,$time1); // 取得递增月;
        }
        $datearr[] = date($format,$time2);
        return array_unique($datearr);
    }

    /**
     * 将数组中的一列值作为键值
     * @param  array $data 数组
     * @param  string $key 键名
     * @return array
     */
    public function indexArrKey($data, $key)
    {
        return array_combine(array_column($data, $key), $data);
    }
}