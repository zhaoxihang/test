<?php


namespace app\application\factory\lib;


use app\application\abstractFactory\AbstractFactory;
use app\application\factory\Interfaces\Color;
use app\application\factory\Interfaces\Shape;

/**
 * 颜色工厂
 * Class ColorFactory
 * @package app\application\factory\lib
 */
class ColorFactory extends AbstractFactory
{
    private $color ;

    public function getColor(string $shapeType):Color{
        if(empty($shapeType)){
            throw new \RuntimeException('Color参数有误:', 40004);
        }

        $method = parse_name($shapeType, 1);
        $class = __NAMESPACE__ . "\\color\\" .$method;
        if (class_exists($class)) {
            $this->color = new $class();
        } else {
            throw new \RuntimeException('Color for Method:', 40004);
        }

        return $this->color;
    }

    public function getShape(string $shape): Shape
    {
        return null;
    }
}