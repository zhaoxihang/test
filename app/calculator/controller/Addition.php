<?php


namespace app\calculator\controller;


class Addition extends CalBase
{
    public function calculate(){
        $number = $this->num_one + $this->num_two;
        return $number;
    }
}