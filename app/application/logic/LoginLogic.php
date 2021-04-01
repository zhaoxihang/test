<?php


namespace app\application\logic;


use app\application\service\LoginService;

class LoginLogic
{

    private $web_name = false;

    public function __construct($web_name)
    {
        $this->web_name = $web_name.'_';
    }

    //手机号密码登录
    const TYPE_MOBILE_LOGIN = 1;
    //验证码登录
    const TYPE_VERIFY_LOGIN = 2;
    //注册并登录
    const TYPE_REGISTER_LOGIN = 3;

    private $login_service = false;


    function getUserInfo(){
        // todo 返回用户信息
        return [];
    }

    function getLoginService(){
        if($this->login_service == false){
            $this->login_service = new LoginService($this->web_name);
        }
        return $this->login_service;
    }

    function doLogin($param){
        switch ($param['type'])
        {
            case self::TYPE_MOBILE_LOGIN:
                return $this->doUserPassLogin($param);
                break;
            case self::TYPE_VERIFY_LOGIN:
                return $this->doUserVerifyLogin($param);
                break;
            case self::TYPE_REGISTER_LOGIN:
                return $this->doUserRegisterLogin($param);
                break;
        }
    }

    /**
     * 手机号密码登录
     * @param $param
     * @return bool
     */
    function doUserPassLogin($param){
        // todo 校验param中是否有mobile，password
        return $this->getLoginService()->login($param['mobile'],$param['password']);
    }

    /**
     * 手机号验证码登录
     * @param $param
     * @return bool
     */
    function doUserVerifyLogin($param){
        // todo 校验param中是否有mobile，verification
        return $this->getLoginService()->mobileVerifyLogin($param['mobile'],$param['verification']);
    }

    function doUserRegisterLogin($param){
        return $this->getLoginService()->register($param['mobile'],$param['password'],$param['verification']);
    }
}