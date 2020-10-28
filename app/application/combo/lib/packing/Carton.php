<?php


namespace app\application\combo\lib\packing;


use app\application\combo\Interfaces\Packing;

/**
 * 纸盒包装
 * Class Carton
 * @package app\application\combo\lib\packing
 */
class Carton implements Packing
{

    public function pack(): string
    {
        return '纸盒';
    }
}