<?php


namespace app\calculator\controller;


use app\calculator\Interfaces\Icalculate;

abstract class CalBase implements Icalculate
{
    protected $num_one;
    protected $num_two;
    public function __construct($param)
    {
        $this->num_one = $param['num_one'];
        $this->num_two = $param['num_two'];
    }

    abstract public function calculate();
}