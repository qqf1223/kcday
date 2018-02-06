<?php

namespace App\Services;

abstract class KcService
{
    protected function handleError($msgOrData = '', $data = null, $statusCode = 302)
    {
        if(is_array($msgOrData)){
            $data = $msgOrData;
            $msgOrData = '';
        }
        return $this->handleResult(false, $msgOrData, $data, $statusCode);
    }

    protected function handleSuccess($msg = '', $data = null, $statusCode = 200)
    {
        return $this->handleResult(true, $msg, $data, $statusCode);
    }

    protected function handleResult($status, $msg = null, $data = null, $statusCode = 200)
    {
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'code' => $statusCode
        ];
    }
}
