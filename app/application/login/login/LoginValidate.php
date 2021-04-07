<?php


namespace app\application\login\login;


use app\application\error\ErrorMsg;
use think\facade\Validate;

class LoginValidate
{
    static function validate_mobile_password($param):bool
    {
        $rule = [
            'mobile' => 'require|mobile',
            'password' => 'require',
        ];
        $message = [
            'mobile.require' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'password.require' => '密码不能为空',
        ];
        $validate = Validate::rule('age')->rule($rule)->message($message);
        if(!$validate->check($param)){
            ErrorMsg::setErrorMsg($validate->getError());
            return false;
        }
        return true;
    }

    static function validate_mobile_verification($param):bool
    {
        $rule = [
            'mobile' => 'require|mobile',
            'verification' => 'require',
        ];
        $message = [
            'mobile.require' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'verification.require' => '验证码不能为空',
        ];
        $validate = Validate::rule('age')->rule($rule)->message($message);
        if(!$validate->check($param)){
            ErrorMsg::setErrorMsg($validate->getError());
            return false;
        }
        return true;
    }

    static function validate_mobile_verification_or_password($param):bool
    {
        $rule = [
            'verification' => 'require',
        ];
        $validate = Validate::rule('age')->rule($rule);
        if(!$validate->check($param)){
            return static::validate_mobile_password($param);
        }
        return static::validate_mobile_verification($param);


    }
}