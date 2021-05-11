<?php


namespace app\application\alipay\easy\tools;


class config
{
    static function getConfig(){
        return [
            'appId'=>'',
            'rsaPrivateKey'=>'',
            'alipayPublicKey'=>'',
        ];
    }
}