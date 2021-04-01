<?php


namespace app\application\service;


use app\application\session\SessionService;

class LoginService
{

    private $web_name = false;

    public function __construct($web_name)
    {
        $this->web_name = $web_name.'_';
    }

    function login($mobile , $password){
        return $this->userInfo($mobile,$password);
    }

    function mobileVerifyLogin($mobile,$verification){
        // todo 根据手机号，验证码去查询验证码是否正确，正确就
        return $this->userInfo($mobile);
    }

    /**
     * 注册并登录
     * @param $mobile
     * @param bool $password
     * @param bool $verification
     * @return bool
     */
    function register($mobile,$password = false,$verification = false){
        // todo 根据手机号,密码，验证码去注册用户
        return $this->userInfo($mobile);
    }

    function userInfo($mobile ,$password = false){
        // todo 根据手机号,密码去查询用户信息 ,查到就返回用户信息 并存session，否则返回false
//        $fun_name = 'set_'.$this->web_name.'user_id';
//        SessionService::$fun_name();
        return false;
    }
}