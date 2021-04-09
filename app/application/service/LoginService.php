<?php


namespace app\application\service;


use app\application\alipay\Alipay;
use app\application\error\ErrorMsg;
use app\application\Logic\JwtLogic;
use app\application\session\SessionService;
use app\model\ThirdPartyAssociation;
use app\model\User;

class LoginService
{

    private $web_name = false;

    private $login_class_name = false;

    private $user_model = false;

    private $token = false;

    public function __construct($web_name,$login_class_name)
    {
        $this->web_name = $web_name;
        $this->login_class_name = $login_class_name;
    }

    function getWebName(){
        return $this->web_name;
    }

    function getLoginClassName(){
        return $this->login_class_name;
    }

    function login($mobile , $password){
        return $this->userInfo($mobile,$password);
    }

    public function hasLogin($param_token){
        $login = false;
        //todo token 查询数据库取得最近一条
        if(self::validationToken($param_token)){
            $token = self::parseToken($param_token);
            //判断token里用户信息
            $fun_name = 'get_'.$this->getWebName().'_user_id';
            if($token->claims()->get('user_id') == SessionService::$fun_name()){
                $login = true;
            }
        }
        return $login;
    }

    /**
     * 验证令牌
     * @param $token
     * @return bool
     */
    static function validationToken($token){
        $user_id = SessionService::get_blog_user_id();
        return JwtLogic::validationToken($token,$user_id);
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
     * 获取 jwt token
     * @return bool|string
     */
    public function getToken(){
        if($this->token == false){
            $user_id = SessionService::get_blog_user_id();
            $token = JWTLogic::createToken($user_id);

            //todo token 存数据库，生成md5 32位的字符串返回给前端使用

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
            if(!$this->is_verification($mobile,$verification)) return false;
        }
        $this->user_model = User::createUser(['user_name'=>'默认用户名','mobile'=>$mobile,'password'=>$password]);
        if($this->user_model->isEmpty()){
            //错误信息 ：手机号已注册
            ErrorMsg::setErrorMsg('手机号已注册');
            return false;
        }
        $fun_name = 'set_'.$this->getWebName().'_user_id';
        SessionService::$fun_name($this->user_model->id);
        return $this->user_model;
    }

    function thirdLogin($auth_code){
        $fun_name = 'get'.$this->getLoginClassName().'Token';
        $result = $this->$fun_name($auth_code);
        if($result){
            //根据第三方用户id取得
            $user_id = $this->getUserIdToThirdId($result->userId);
            return $user_id?$this->userInfo(false,false,$user_id):false;
        }
        return false;
    }

    function getUserIdToThirdId($thirdUserId){
        // 去第三方用户表查询用户id；
        $third_model = ThirdPartyAssociation::getAssociationByThirdUserId($thirdUserId);
        if($third_model || $third_model->isEmpty()){
            ErrorMsg::setErrorMsg('第三方用户未关联');
            return false;
        }
        return $third_model;
    }

    /**
     * 获取ali第三方登录返回值
     * @param $auth_code
     * @return \Alipay\EasySDK\Base\OAuth\Models\AlipaySystemOauthTokenResponse|bool
     * @throws \Exception
     */
    function getAlipayToken($auth_code){
        $alipay = new Alipay();
        return $alipay->getToken($auth_code);
    }

    function is_verification($mobile,$verification) :bool
    {
        //todo 验证验证码是否正确 todo 错误信息 ：验证码错误
        return false;
    }

    function userInfo($mobile = false ,$password = false,$user_id = false){
        if($this->user_model == false){
            $this->user_model = User::getModelForMobileAndPass($mobile,$password,$user_id );
        }
        if($this->user_model->isEmpty()){
            // 错误信息 ：该用户不存在
            ErrorMsg::setErrorMsg('该用户不存在');
            return false;
        }
        $fun_name = 'set_'.$this->getWebName().'_user_id';
        SessionService::$fun_name($this->user_model->id);
        return $this->user_model;
    }
}