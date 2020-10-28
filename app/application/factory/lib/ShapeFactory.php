<?php


namespace app\application\factory\lib;


use app\application\abstractFactory\AbstractFactory;
use app\application\factory\Interfaces\Color;
use app\application\factory\Interfaces\Shape;
use http\Exception\RuntimeException;

/**
 * 图形工厂
 * Class ShapeFactory
 * @package app\application\factory\lib
 */
class ShapeFactory extends AbstractFactory
{
    private $instance ;

    public function getShape(string $shapeType):Shape{
        if(empty($shapeType)){
            throw new RuntimeException('Shape参数有误:', 40004);
        }

        $method['code'] = parse_name($shapeType, 1);
        $class = __NAMESPACE__ . "\\shape\\" .$method['code'];
        if (class_exists($class)) {
            $this->instance = new $class();
        } else {
            throw new RuntimeException('Shape for Method:', 40004);
        }

        return $this->instance;
    }

    public function getColor(string $color): Color
    {
        return null;
    }
}