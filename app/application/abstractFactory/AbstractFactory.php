<?php


namespace app\application\abstractFactory;


use app\application\factory\Interfaces\Color;
use app\application\factory\Interfaces\Shape;

abstract class AbstractFactory
{
    abstract public function getColor(string $color):Color ;

    abstract public function getShape(string $shape):Shape ;
}