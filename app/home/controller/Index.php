<?php


namespace app\home\controller;

use app\calculator\Operator;
use app\validate\Calculation;
use think\exception\ValidateException;
use think\Validate;

class Index
{
    public function calculation(){
        $param = input();
        $num_one = $param['num_one'] = 1;
        $num_two = $param['num_two'] = 2;
        $operator = $param['operator'] = 4;

        //vaildata 验证必传
        try {
            validate(Calculation::class)->check($param);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            dump($e->getError());die;
        }
        $operator = new Operator($param);
        $number = $operator->getResult();
        return $number;
    }

    public function test(){
        echo '测试';
    }
}