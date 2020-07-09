<?php


namespace app\calculator;


use app\calculator\controller\Addition;
use app\calculator\controller\Division;
use app\calculator\controller\Multiplication;
use app\calculator\controller\Subtraction;

class Operator
{
    protected $number;
    public function __construct($param)
    {
        switch ($param['operator']){
            case '1':
                //+
                $add = new Addition($param);
                $this->number = $add->calculate();
                break;
            case '2':
                //-
                $subtraction = new Subtraction($param);
                $this->number = $subtraction->calculate();
                break;
            case '3':
                //*
                $multi = new Multiplication($param);
                $this->number = $multi->calculate();
                break;
            case '4':
                // /
                $division =  new Division($param);
                $this->number = $division->calculate();
                break;
        }
    }

    public function getResult(){
        return $this->number;
    }
}