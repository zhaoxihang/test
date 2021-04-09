<?php


namespace app\application\alipay;


use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;
use app\application\error\ErrorMsg;
use app\application\session\SessionService;

class Alipay
{

    public $auth_code_result = false;

    public function __construct()
    {
        Factory::setOptions($this->getOptions());
    }

    function getOptions(){
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';

        $options->appId = '';

        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = '';

//        $options->alipayCertPath = '<-- 请填写您的支付宝公钥证书文件路径，例如：/foo/alipayCertPublicKey_RSA2.crt -->';
//        $options->alipayRootCertPath = '<-- 请填写您的支付宝根证书文件路径，例如：/foo/alipayRootCert.crt" -->';
//        $options->merchantCertPath = '<-- 请填写您的应用公钥证书文件路径，例如：/foo/appCertPublicKey_2019051064521003.crt -->';

        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
         $options->alipayPublicKey = '';

        //可设置异步通知接收服务地址（可选）
//        $options->notifyUrl = "<-- 请填写您的支付类接口异步通知接收服务地址，例如：https://www.test.com/callback -->";

        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
//        $options->encryptKey = "<-- 请填写您的AES密钥，例如：aa4BtZ4tspm2wnXLb1ThQA== -->";


        return $options;
    }

    /**
     * @param $auth_code
     * @return \Alipay\EasySDK\Base\OAuth\Models\AlipaySystemOauthTokenResponse|bool
     * @throws \Exception
     */
    function getToken($auth_code){
        if($this->auth_code_result == false){
            $this->auth_code_result = Factory::base()->oauth()->getToken($auth_code);
        }

        if(empty($this->auth_code_result->code) || empty($this->auth_code_result->msg) || empty($this->auth_code_result->subCode) || empty($this->auth_code_result->subMsg)
        )
        {
            return $this->auth_code_result;
        }
        ErrorMsg::setErrorMsg($this->auth_code_result->msg);
        return false;
    }
}