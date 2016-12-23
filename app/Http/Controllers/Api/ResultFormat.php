<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ReturnCode;

class ResultFormat
{
    private $pCode;
    private $pData;

    public function __construct($code, $data = NULL)
    {
        $this->pCode   = $code;
        $this->pData   = $data;
    }

    public function toArray()
    {
        $ret['retcode'] = $this->pCode;
        $ret['msg'] = ReturnCode::$Msg[$this->pCode];

        if ($this->pData) {
            $ret['data'] = $this->pData;
        }

        return $ret;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

}

