<?php


namespace app\application\combo\lib\packing;


use app\application\combo\Interfaces\Packing;

/**
 * 瓶子包装
 * Class Bottle
 * @package app\application\combo\lib\packing
 */
class Bottle implements Packing
{

    public function pack(): string
    {
        return '瓶装';
    }
}