<?php
namespace Manpro\Request;

class Client
{
    public function __construct($url, $headers=[])
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);   //定义header
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);      //不直接输出
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);      //直接跳转重定向
    }

    public function post($post_data = [])
    {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        return $this->rcExec($post_data);
    }

    public function get()
    {
        curl_setopt($this->ch, CURLOPT_POST, 0);
        return $this->rcExec();
    }

    public function put($post_data = [])
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        return $this->rcExec($post_data);
    }

    public function patch($post_data = [])
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        return $this->rcExec($post_data);
    }

    public function delete()
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->rcExec();
    }

    public function rcExec($post_data = [])
    {
        if ($post_data) {
            $query = [];
            foreach ($post_data as $field => $value) {
                $query[] = $field.'='. $value;
            }
            $query_str = implode('&', $query);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $query_str);
        }
        return curl_exec($this->ch);
    }

    public function __destruct()
    {
        curl_close($this->ch);      //关闭连接
    }
}
