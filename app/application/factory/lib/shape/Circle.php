<?php


namespace app\application\factory\lib\shape;


use app\application\factory\Interfaces\Shape;

/**
 * 圆
 * Class Circle
 * @package app\application\factory\lib\shape
 */
class Circle implements Shape
{

    public function draw()
    {
        return 'Circle';
    }
}