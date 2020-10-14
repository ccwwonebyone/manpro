<?php

namespace Manpro;

trait ManproError
{
    protected $manproErrors = [];

    /**
     * @param $errorMsg
     * @param  string|null  $key
     */
    public function setError($errorMsg, $key = null)
    {
        if ($key) {
            $this->manproErrors[$key] = $errorMsg;
        } else {
            $this->manproErrors[] = $errorMsg;
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->manproErrors;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return !empty($this->manproErrors);
    }

    /**
     * @param $key
     * @return mixed
     * @throws ManproException
     */
    public function getKeyError($key)
    {
        if (!key_exists($key, $this->manproErrors)) {
            throw new ManproException('here is no error key: '.$key);
        }
        return $this->manproErrors[$key];
    }

    /**
     * @return mixed
     */
    public function firstError()
    {
        return reset($this->manproErrors);
    }
}
