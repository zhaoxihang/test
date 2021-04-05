<?php


namespace app\application\service;


use app\application\Logic\JwtLogic;
use app\application\session\SessionService;
use app\blog\model\User;

class LoginService
{

    private $web_name = false;

    private $user_model = false;

    private $token = false;

    public function __construct($web_name)
    {
        $this->web_name = $web_name.'_';
    }

    function login($mobile , $password){
        return $this->userInfo($mobile,$password);
    }

    public function hasLogin(){
        $login = false;
        $param_token = input('token');
        if(self::validationToken($param_token)){
            $token = self::parseToken($param_token);
            //判断token里用户信息
        }
        return $login;
    }

    static function validationToken($token){
        return JwtLogic::validationToken($token);
    }

    /**
     * 解析token
     * @param $token
     * @return \Lcobucci\JWT\Token|string
     */
    static function parseToken($token){
        return JwtLogic::parseToken($token);
    }

    /**
     * 获取token
     * @return bool|string
     */
    public function getToken(){
        if($this->token == false){
            $token = JWTLogic::createToken();
            $this->token = $token;
        }
        return $this->token;
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