<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Calculation extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'num_one'  => 'require|number',
        'num_two'  => 'require|number',
        'operator' => 'require|number'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'num_one.require' => '数字1必须',
        'num_one.number' => '数字1必须是数字类型',
        'num_two.require' => '数字2必须',
        'num_two.number' => '数字2必须是数字类型',
        'operator.require' => '计算符号必须',
        'operator.number' => '计算符号必须是数字类型'
    ];
}
