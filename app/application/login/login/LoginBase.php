<?php


namespace app\application\login\login;


use app\application\login\interfaces\ILogin;
use app\application\logic\LoginLogic;
use app\application\session\SessionService;
use app\Request;

class LoginBase implements ILogin
{
    private $login_logic = false;

    private $web_name = false;

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
     * @return mixed
     */
    function hasLogin()
    {
        $fun_name = 'get_'.$this->web_name.'user_id';
        return SessionService::$fun_name();
    }

    /**
     * 登录
     */
    function login()
    {
        if($this->hasLogin()){
            $this->show_data($this->loginSuccessOperation());
        }else{
            $this->doLogin();
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
            $this->show_data($this->loginErrorOperation());
        }
        $this->thirdparty();

        if($this->hasLogin()){
            $this->show_data($this->loginSuccessOperation());
        }else{
            $this->show_data($this->loginErrorOperation());
        }
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
        return ['status'=>true,'data'=>$this->getLoginLogic()->getUserInfo()];
    }

    function loginErrorOperation(){
        // todo 获取错误信息
        $msg = '';
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