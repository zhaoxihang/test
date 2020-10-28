<?php


namespace app\application\combo\lib\Item\Drink;


use app\application\combo\Interfaces\Item;
use app\application\combo\Interfaces\Packing;
use app\application\combo\lib\packing\Bottle;

/**
 * 饮料基类
 * Class ColdDrink
 * @package app\application\combo\lib\Item\ColdDrink
 */
abstract class Drink implements Item
{


    /**
     * 食物包装
     * @return mixed
     */
    public function packing(): Packing
    {
        return new Bottle();
    }

    /**
     * 食物价格
     * @return float
     */
    public abstract function price(): float ;
}