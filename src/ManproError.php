<?php
namespace Manpro;

trait ManproError
{
    protected $manpro_errors = [];

    public function setError($error_msg, $key = null)
    {
        if($key){
            $this->manpro_errors[$key] = $error_msg;
        }else{
            $this->manpro_errors[] = $error_msg;
        }
    }

    public function getErrors()
    {
        return $this->manpro_errors;
    }

    public function isError()
    {
        return !empty($this->manpro_errors);
    }

    public function getKeyError($key)
    {
        if(!key_exists($key, $this->manpro_errors)){
            throw new ManproException('here is no error key:'.$key);
        }
        return $this->manpro_errors[$key];
    }

    public function firstError()
    {
        return reset($this->manpro_errors);
    }
}