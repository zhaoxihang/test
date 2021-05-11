<?php


namespace app\application\alipay\easy\lib\base\oAuth;


class Get extends OAuth
{
    function run($code)
    {
        return $this->getOAuth()->getToken($code);
    }
}