<?php
declare (strict_types = 1);

namespace app\blog\validate;

use think\Validate;

class CreateUser extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'user_name'=> 'require',
        'mobile'=> 'require|mobile',
        'password'=> 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'user_name.require' => '用户名必填',
        'mobile.require' => '手机号必填',
        'mobile.mobile' => '手机号格式不正确',
        'password.require' => '密码不能为空',
    ];
}
