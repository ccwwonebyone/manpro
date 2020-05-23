<?php

namespace Manpro\Tools;

use Manpro\ManproException;

class Algorithm
{
    /**
     * 解析最小代码组
     * ['1215','121516','121416','12141617']  返回 ['1215','121416']
     * @param  array  $area_codes
     * @return array
     */
    public function getMinArrCode($area_codes)
    {
        $minLength = strlen(reset($area_codes));
        $searchArr = array(current($area_codes));
        foreach ($area_codes as $value) {
            if ($minLength < strlen($value)) {
                continue;
            }
            if ($minLength > strlen($value)) {
                $minLength = strlen($value);
                $searchArr = array();
                $searchArr[] = $value;
            }
            if ($minLength == strlen($value)) {
                $searchArr[] = $value;
            }
        }
        $searchArr = array_unique($searchArr);
        $check_area_code = array_diff($area_codes, $searchArr);
        foreach ($check_area_code as $key => $value) {
            foreach ($searchArr as $val) {
                if (strpos($value, $val) === 0) {
                    unset($check_area_code[$key]);
                }
            }
        }
        if (!empty($check_area_code)) {
            $searchArr = array_merge($searchArr, $this->getMinArrCode($check_area_code));
        }
        return $searchArr;
    }

    /**
     * 浮点型转16进制，浮点型->计算器储存类型->16进制
     * 浮点型x86cpu 小端 二进制码
     * 1位     符号位
     * 2-9位   指数位
     * 10-32位 尾数位
     * @param  float  $float  浮点数字
     * @return  string
     */
    public function floatToHex(float $float)
    {
        //符号位
        $sign = $float > 0 ? '0' : '1';
        list($integer, $decimal) = explode('.', (string) $float);
        $integer = decbin($integer);

        $index_decimal = $decimal = floatval('0.'.$decimal);
        //指数位
        if (abs($float) >= 1) {
            $index = strlen($integer) - 1;
        } else {
            for ($i = 0; $i < 23; $i++) {
                $index_decimal = $index_decimal * 2;
                if ($index_decimal >= 1) {
                    $index = -$i - 1;
                    break;
                }
            }
        }
        $index = sprintf('%08d', decbin(127 + $index));

        //尾数位
        $mantissa = abs($float) >= 1 ? $integer : '';
        while (strlen($mantissa) < 24) {
            $decimal = $decimal * 2;
            if ($decimal >= 1) {
                $decimal = $decimal - 1;
                $mantissa .= '1';
            } else {
                $mantissa .= $mantissa ? '0' : '';
            }
        }
        $mantissa = substr($mantissa, 1);

        //计算器储存类型
        $binary = $sign.$index.$mantissa;
        return base_convert($binary, 2, 16);
    }
}
