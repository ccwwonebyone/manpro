<?php

namespace Manpro\Request;

class Client
{
    /**
     * @var false|resource
     */
    private $ch;

    public function __construct($url, $headers = [])
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);   //定义header
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);      //不直接输出
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);      //直接跳转重定向
    }

    /**
     * post 请求
     * @param  array  $postData post数据
     * @return string
     */
    public function post($postData = [])
    {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        return $this->rcExec($postData);
    }

    /**
     * get 请求
     * @return  string
     */
    public function get()
    {
        curl_setopt($this->ch, CURLOPT_POST, 0);
        return $this->rcExec();
    }

    /**
     * put请求
     * @param  array  $postData 数据
     * @return string
     */
    public function put($postData = [])
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        return $this->rcExec($postData);
    }

    /**
     * pacth
     * @param  array  $postData 数据
     * @return string
     */
    public function patch($postData = [])
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        return $this->rcExec($postData);
    }

    /**
     * delete
     * @return string
     */
    public function delete()
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->rcExec();
    }

    /**
     * 执行curl
     *
     * @param  array  $postData
     * @return string
     */
    protected function rcExec($postData = [])
    {
        if ($postData) {
            $query = [];
            foreach ($postData as $field => $value) {
                $query[] = $field.'='.$value;
            }
            $queryStr = implode('&', $query);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $queryStr);
        }
        return curl_exec($this->ch);
    }

    public function __destruct()
    {
        curl_close($this->ch);      //关闭连接
    }
}
