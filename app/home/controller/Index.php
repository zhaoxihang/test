<?php


namespace app\home\controller;

use app\calculator\Operator;
use think\Validate;

class Index
{
    public function index(){
        $param = input();
        $num_one = $param['num_one'] = 1;
        $num_two = $param['num_two'] = 2;
        $operator = $param['operator'] = 1;

        $rules = [
            'num_one'=>'request|number',
            'num_two'=>'request|number',
            'operator'=>'request|number'
        ];
        $message  =   [
            'num_one.require' => '数字1必须',
            'num_one.number' => '数字1必须是数字类型',
            'num_two.require' => '数字2必须',
            'num_two.number' => '数字2必须是数字类型',
            'operator.require' => '计算符号必须',
            'operator.number' => '计算符号必须是数字类型'
        ];
        //todo vaildata 验证必传
        $validate = Validate();
        $validate->message($message);
//        if($validate->check($param)){
//            dump($validate->getError());
//        }
        $operator = new Operator($param);
        $number = $operator->getResult();
        return $number;
    }
}