<?php


namespace app\application\alipay\easy\lib\base\qrCode;


class Create extends QrCode
{

    function run($param)
    {
        return $this->getQrCode()->create($param['urlParam'], $param['queryParam'], $param['describe']);
    }
}