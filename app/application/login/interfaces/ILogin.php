<?php
namespace app\application\login\interfaces;

use app\Request;

interface ILogin
{
    /**
     * 是否登录
     * @return mixed
     */
    function hasLogin();

    /**
     * 登录
     * @return mixed
     */
    function login();

    /**
     * 去登陆
     * @return mixed
     */
    function doLogin();

    /**
     * 退出登录
     * @return mixed
     */
    function loginOut();

    /**
     * 登录成功后操作
     * @return mixed
     */
    function loginSuccessOperation();

    /**
     * 登录失败后操作
     * @return mixed
     */
    function loginErrorOperation();

    /**
     * 最终返回
     * @param $data
     * @return mixed
     */
    function show_data($data);
}