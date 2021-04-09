<?php


namespace app\application\logic;


use app\application\error\ErrorMsg;
use app\application\login\tools\LoginValidate;
use app\application\service\LoginService;
use think\Model;

class LoginLogic
{

    private $web_name = false;

    private $login_class_name = false;

    public function __construct($web_name,$login_class_name)
    {
        $this->web_name = $web_name;
        $this->login_class_name = $login_class_name;
    }

    /**
     * 判断是否登录
     * @param $param_token
     * @return bool
     */
    public function hasLogin($param_token){
        return $this->getLoginService()->hasLogin($param_token);
    }

    //手机号密码登录
    const TYPE_MOBILE_LOGIN = 1;
    //验证码登录
    const TYPE_VERIFY_LOGIN = 2;
    //注册并登录
    const TYPE_REGISTER_LOGIN = 3;
    //第三方登录
    const TYPE_THIRD_LOGIN = 4;

    private $login_service = false;

    private $user_model = false;

    private $token = false;

    /**
     * 获取用户信息
     * @return bool|Model
     */
    function getUserInfo(){
        return $this->user_model;
    }

    /**
     * 获取jwt token
     * @return bool|string
     */
    function getToken(){
        if($this->token == false){
            $this->token = $this->getLoginService()->getToken();
        }
        return $this->token;
    }

    /**
     * @return LoginService|bool
     */
    function getLoginService(){
        if($this->login_service == false){
            $this->login_service = new LoginService($this->web_name,$this->login_class_name);
        }
        return $this->login_service;
    }

    /**
     * 登录主方法
     * @param $param
     * @return array|bool|Model|null
     */
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
            case self::TYPE_THIRD_LOGIN:
                return $this->user_model = $this->doUserThirdLogin($param);
                break;
        }
    }

    /**
     * 手机号密码登录
     * @param $param
     * @return bool
     */
    function doUserPassLogin($param){
        // 校验param中是否有mobile，password
        if(LoginValidate::validate_mobile_password($param)){
            return $this->getLoginService()->login($param['mobile'],$param['password']);
        }
        return false;
    }

    /**
     * 手机号验证码登录
     * @param $param
     * @return bool
     */
    function doUserVerifyLogin($param){
        // 校验param中是否有mobile，verification
        if(LoginValidate::validate_mobile_verification($param)){
            return $this->getLoginService()->mobileVerifyLogin($param['mobile'],$param['verification']);
        }
        return false;
    }

    /**
     * 注册并登录 可以用密码也可以用短信验证码
     * @param $param
     * @return bool|\think\Model
     */
    function doUserRegisterLogin($param){
        // 校验param中是否有mobile，verification或者password
        if(isset($param['password']) && !empty($param['password'])){
            $param['verification'] = false;
        };
        if(isset($param['verification']) && !empty($param['verification'])){
            $param['password'] = false;
        };
        if(LoginValidate::validate_mobile_verification_or_password($param)){
            return $this->getLoginService()->register($param['mobile'],$param['password'],$param['verification']);
        }
        return false;
    }

    /**
     * 第三方登录
     * @param $param
     * @return array|bool|Model|null
     */
    function doUserThirdLogin($param){
        if(!isset($param['auth_code']) || empty($param['auth_code'])){
            ErrorMsg::setErrorMsg('第三方参数未传');
            return false;
        };
        return $this->getLoginService()->thirdLogin($param['auth_code']);
    }
}