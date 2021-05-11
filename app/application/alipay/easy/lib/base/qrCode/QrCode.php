<?php


namespace app\application\alipay\easy\lib\base\qrCode;


use app\application\alipay\easy\lib\base\Base;

abstract class QrCode extends Base
{
    function getQrCode(){
        return $this->getBase()->Qrcode();
    }
}