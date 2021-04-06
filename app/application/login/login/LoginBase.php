<?php


namespace app\application\login\login;


use app\application\error\ErrorMsg;
use app\application\login\interfaces\ILogin;
use app\application\logic\LoginLogic;
use app\application\session\SessionService;
use app\Request;

class LoginBase implements ILogin
{
    private $login_logic = false;

    private $web_name = false;

    private $token = false;

    public function __construct($web_name)
    {
        $this->web_name = $web_name.'_';
    }

    public function getLoginLogic(){
        if($this->login_logic == false){
            $this->login_logic = new LoginLogic($this->web_name);
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
     * 登录
     */
    function login()
    {
        $param_token = input('token');
        if($param_token && $this->hasLogin($param_token)){
            return $this->show_data($this->loginSuccessOperation());
        }else{
            return $this->doLogin();
        }
    }

    /**
     * 去登陆
     * @return mixed
     */
    function doLogin()
    {
        $param = input();
        if(!$this->getLoginLogic()->doLogin($param)){
            //未登录成功
            return $this->show_data($this->loginErrorOperation());
        }
        //获取token
        $param_token = $this->getToken($param);

        $this->thirdparty();

        if($this->hasLogin($param_token)){
            return $this->show_data($this->loginSuccessOperation());
        }else{
            return $this->show_data($this->loginErrorOperation());
        }
    }

    function getToken($param){
        if(isset($param['token']) && empty($param['token'])){
            return $this->token = $param['token'];
        }
        return $this->token = $this->getLoginLogic()->getToken();
    }

    /**
     * 第三方登录
     */
    function thirdparty()
    {

    }

    /**
     * 退出登录
     */
    function loginOut()
    {
        $fun_name = 'delete_'.$this->web_name.'user_id';
        SessionService::$fun_name();
    }

    /**
     * 登录成功后操作
     * @return mixed
     */
    function loginSuccessOperation()
    {
        $user_info = $this->getLoginLogic()->getUserInfo()->toArray();
        unset($user_info['password']);
        $user_info['token'] = $this->token;
        return ['status'=>true,'data'=>$user_info];
    }

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