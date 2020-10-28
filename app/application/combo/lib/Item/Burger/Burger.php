<?php


namespace app\application\combo\lib\Item\Burger;


use app\application\combo\Interfaces\Item;
use app\application\combo\Interfaces\Packing;
use app\application\combo\lib\packing\Carton;

/**
 * 汉堡包基类
 * Class Burger
 * @package app\application\combo\lib\Item\Burger
 */
abstract class Burger implements Item
{

    /**
     * 食物包装
     * @return mixed
     */
    public function packing(): Packing
    {
        return new Carton();
    }

    /**
     * 食物价格
     * @return float
     */
    public abstract function price(): float ;
}