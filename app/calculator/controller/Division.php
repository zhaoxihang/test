<?php


namespace app\calculator\controller;


class Division extends CalBase
{
    public function calculate(){
        if($this->num_two != 0){
            $number = $this->num_one / $this->num_two;
        }else{
            $number = '除数不能是0';
        }
        return $number;
    }
}