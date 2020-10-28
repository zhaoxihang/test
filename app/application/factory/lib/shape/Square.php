<?php


namespace app\application\factory\lib\shape;


use app\application\factory\Interfaces\Shape;

/**
 * 正方形
 * Class Square
 * @package app\application\factory\lib\shape
 */
class Square implements Shape
{

    public function draw()
    {
        return 'Square';
    }
}