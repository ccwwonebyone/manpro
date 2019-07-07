<?php
namespace Manpro\Tools;

use Manpro\ManproException;

class Algorithm extends Tool
{
    /**
     * 解析最小代码组
     * ['1215','121516','121416','12141617']  返回 ['1215','121416']
     * @param  array $areacodes
     * @return array
     */
    public function getMinArrCode($areacodes)
    {
        $minLength = strlen(reset($areacodes));
        $searchArr = array(current($areacodes));
        foreach ($areacodes as $value) {
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
        $checkAreacode = array_diff($areacodes, $searchArr);
        foreach ($checkAreacode as $key => $value) {
            foreach ($searchArr as $val) {
                if (strpos($value, $val) === 0) {
                    unset($checkAreacode[$key]);
                }
            }
        }
        if (!empty($checkAreacode)) {
            $searchArr = array_merge($searchArr, $this->getMinArrCode($checkAreacode));
        }
        return $searchArr;
    }


}
