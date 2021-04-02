<?php


namespace app\application\service;


use app\application\session\SessionService;
use app\blog\model\User;

class LoginService
{

    private $web_name = false;

    private $user_model = false;

    public function __construct($web_name)
    {
        $this->web_name = $web_name.'_';
    }

    function login($mobile , $password){
        return $this->userInfo($mobile,$password);
    }

    function mobileVerifyLogin($mobile,$verification){
        if(!$this->is_verification($mobile,$verification)){
            return false;
        }
        return $this->userInfo($mobile);
    }

    /**
     * 注册并登录
     * @param $mobile
     * @param bool $password
     * @param bool $verification
     * @return bool|\think\Model
     */
    function register($mobile,$password = false,$verification = false){
        if($verification){
            if(!$this->is_verification($mobile,$verification)){
                return false;
            }
        }
        $this->user_model = User::createUser(['user_name'=>'默认用户名','mobile'=>$mobile,'password'=>$password]);
        if($this->user_model->isEmpty()){
            //todo 错误信息 ：手机号已注册
            return false;
        }
        return $this->user_model;
    }

    function is_verification($mobile,$verification) :bool
    {
        //todo 验证验证码是否正确 todo 错误信息 ：验证码错误
        return false;
    }

    function userInfo($mobile ,$password = false){
        if($this->user_model == false){
            $this->user_model = User::getModelForMobileAndPass($mobile,$password);
        }
        if($this->user_model->isEmpty()){
            //todo 错误信息 ：该用户不存在
            return false;
        }
        $fun_name = 'set_'.$this->web_name.'user_id';
        SessionService::$fun_name($this->user_model->id);
        return $this->user_model;
    }
}