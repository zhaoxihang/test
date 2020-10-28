<?php


namespace app\application\factory\lib\shape;


use app\application\factory\Interfaces\Shape;

/**
 * 矩形
 * Class Rectangle
 * @package app\application\factory\lib\shape
 */
class Rectangle implements Shape
{

    public function draw()
    {
        return 'Rectangle';
    }
}