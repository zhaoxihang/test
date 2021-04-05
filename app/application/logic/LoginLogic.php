<?php


namespace app\application\logic;


use app\application\service\LoginService;
use app\application\session\SessionService;

class LoginLogic
{

    private $web_name = false;

    public function __construct($web_name)
    {
        $this->web_name = $web_name.'_';
    }

    public function hasLogin(){
        return $this->getLoginService()->hasLogin();
    }

    //手机号密码登录
    const TYPE_MOBILE_LOGIN = 1;
    //验证码登录
    const TYPE_VERIFY_LOGIN = 2;
    //注册并登录
    const TYPE_REGISTER_LOGIN = 3;

    private $login_service = false;

    private $user_model = false;


    function getUserInfo(){
        return $this->user_model;
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
                return $this->user_model = $this->doUserPassLogin($param);
                break;
            case self::TYPE_VERIFY_LOGIN:
                return $this->user_model = $this->doUserVerifyLogin($param);
                break;
            case self::TYPE_REGISTER_LOGIN:
                return $this->user_model = $this->doUserRegisterLogin($param);
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

    /**
     * 注册并登录 可以用密码也可以用短信验证码
     * @param $param
     * @return bool|\think\Model
     */
    function doUserRegisterLogin($param){
        // todo 校验param中是否有mobile，verification或者password
        return $this->getLoginService()->register($param['mobile'],$param['password'],$param['verification']);
    }
}