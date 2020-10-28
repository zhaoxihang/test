<?php


namespace app\application\abstractFactory;


use app\application\factory\lib\ColorFactory;
use app\application\factory\lib\ShapeFactory;

class FactoryProducer
{
    public static function getFactory(string $choice):AbstractFactory{
        if($choice == 'Color'){
            return new ColorFactory();
        }else if($choice == 'Shape'){
            return new ShapeFactory();
        }
        return null;
    }
}