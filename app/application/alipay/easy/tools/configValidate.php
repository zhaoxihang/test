<?php


namespace app\application\alipay\easy\tools;


use think\Validate;

class configValidate extends Validate
{
    protected $rules = [
        'appId'                =>    'required',
        'rsaPrivateKey'        =>    'required|string',
        'alipayPublicKey'      =>    'required|string',
    ];

    protected $attributes = [
        'rsaPrivateKey'        =>    '开发者私钥',
        'alipayPublicKey'      =>    '支付宝公钥',
    ];

    protected $messages = [
        'required'             =>    ':attribute 请先填写',
        'string'               =>    ':attribute 格式不正确',
    ];
}