<?php


namespace app\application\alipay\easy\lib\base\oAuth;


use app\application\alipay\easy\lib\base\Base;

abstract class OAuth extends Base
{
    function getOAuth(){
        return $this->getBase()->OAuth();
    }
}