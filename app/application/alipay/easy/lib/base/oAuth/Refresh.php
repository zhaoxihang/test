<?php


namespace app\application\alipay\easy\lib\base\oAuth;


class Refresh extends OAuth
{
    function run($refresh_token)
    {
        return $this->getOAuth()->refreshToken($refresh_token);
    }
}