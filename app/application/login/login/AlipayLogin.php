<?php


namespace app\application\login\login;


use app\application\alipay\Alipay;
use app\application\login\interfaces\ITheThirdPartyLogin;
use app\application\login\traits\TheThirdPartyLogin;

class AlipayLogin extends LoginBase implements ITheThirdPartyLogin
{
    use TheThirdPartyLogin;

    /**
     * 第三方登录 不需要做的可以直接返回true
     * @return bool|mixed
     * @throws \Exception
     */
    function thirdparty()
    {
        return $this->bindingThirdPartyUsers();
    }

    /**
     * 获取去除Login的class_name
     * @return mixed
     * @throws \ReflectionException
     */
    function getClassName(){
        return str_replace("Login","",(new \ReflectionClass(get_class()))->getShortName());
    }

}