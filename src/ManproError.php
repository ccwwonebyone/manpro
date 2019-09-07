<?php
namespace Manpro;

trait ManproError
{
    protected $manpro_errors = [];

    public function setError($error_msg, $key = 0)
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
        return (bool)$this->manpro_errors;
    }

    public function getKeyError($key)
    {
        return $this->manpro_errors[$key];
    }

    public function firstError()
    {
        return reset($this->manpro_errors);
    }
}
