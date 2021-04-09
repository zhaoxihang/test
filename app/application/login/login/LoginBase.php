<?php


namespace app\application\login\login;


use app\application\error\ErrorMsg;
use app\application\login\interfaces\ILogin;
use app\application\logic\LoginLogic;
use app\application\session\SessionService;

abstract class LoginBase implements ILogin
{
    /**
     * @var bool |LoginLogic
     */
    private $login_logic = false;

    /**
     * jwt token值
     * @var bool | string
     */
    private $token = false;

    /**
     * 登录渠道的名称
     * @var bool | string
     */
    private $web_name = false;

    /**
     * 请求的参数
     * @var array|mixed
     */
    private $param = [];

    /**
     * 获取->登录渠道名称
     * @return string
     */
    public function getWebName()
    {
        return $this->web_name?:'blog';
    }

    /**
     * LoginBase constructor.
     * @param bool $web_name
     */
    public function __construct($web_name = false)
    {
        $this->param = input();
        $this->web_name = $web_name;
    }

    /**
     * @return LoginLogic|bool
     */
    public function getLoginLogic(){
        if($this->login_logic == false){
            $this->login_logic = new LoginLogic($this->getWebName(),$this->getClassName());
        }
        return $this->login_logic;
    }

    /**
     * 是否登录
     * @param $param_token
     * @return bool|mixed
     */
    function hasLogin($param_token)
    {
        return $this->getLoginLogic()->hasLogin($param_token);
    }

    /**
     * 获取参数值or所有
     * @param bool $key
     * @return array|bool|mixed
     */
    protected function getParam($key = false)
    {
        if ($key && isset($this->param[$key])) {
            return $this->param[$key];
        }

        if($key == false){
            return $this->param;
        }

        return false;
    }

    /**
     * 登录主入口
     * @return mixed|void
     */
    function login()
    {
        $param_token = $this->getParam('token');
        if($param_token && $this->hasLogin($param_token)){
            return $this->show_data($this->loginSuccessOperation());
        }else{
            return $this->doLogin();
        }
    }

    /**
     * 去登陆操作
     * @return mixed
     */
    function doLogin()
    {
        $param = $this->getParam();
        if(!$this->getLoginLogic()->doLogin($param)){
            //未登录成功
            return $this->show_data($this->loginErrorOperation());
        }
        //获取token
        $param_token = $this->getToken();

        //第三方登录
        if(!$this->thirdparty()){
            return $this->show_data($this->loginErrorOperation());
        }
        //是否登录成功
        if($this->hasLogin($param_token)){
            return $this->show_data($this->loginSuccessOperation());
        }else{
            return $this->show_data($this->loginErrorOperation());
        }
    }

    /**
     * 获取当前的类名
     * @return mixed
     */
    abstract public function getClassName();

    /**
     * 获取jwt 返回的token
     * @return array|bool|mixed|string
     */
    function getToken(){
        $token = $this->getParam('token');
        if($token){
            return $this->token = $token;
        }
        return $this->token = $this->getLoginLogic()->getToken();
    }

    /**
     * 第三方登录 不需要做的可以直接返回true
     * @return mixed
     */
    abstract function thirdparty();

    /**
     * 退出登录
     */
    function loginOut()
    {
        $fun_name = 'delete_'.$this->getWebName().'_user_id';
        SessionService::$fun_name();
    }

    /**
     * 登录成功后统一操作
     * @return mixed
     */
    function loginSuccessOperation()
    {
        $user_info = $this->getLoginLogic()->getUserInfo()->toArray();
        unset($user_info['password']);
        $user_info['token'] = $this->token;
        return ['status'=>true,'data'=>$user_info];
    }

    /**
     * 登录流程失败统一操作
     * @return array|mixed
     */
    function loginErrorOperation(){
        // 获取错误信息
        $msg = ErrorMsg::getErrorMsg();
        return ['status'=>false,'msg'=>$msg];
    }

    /**
     * 最终返回
     * @param $data
     * @return mixed|void
     */
    function show_data($data)
    {
        return $data;
    }
}