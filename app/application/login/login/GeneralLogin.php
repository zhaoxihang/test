<?php


namespace app\application\login\login;

/**
 * 普通登录
 * Class GeneralLogin
 * @package app\application\login\login
 */
class GeneralLogin extends LoginBase
{
    /**
     * 第三方登录 不需要做的可以直接返回true
     * @return mixed
     */
    public function thirdparty(){
        return true;
    }

    /**
     * 获取去除Login的class_name
     * @return mixed
     * @throws \ReflectionException
     */
    function getClassName(){
        return str_replace("Login","",(new \ReflectionClass(get_class()))->getShortName());
    }
}