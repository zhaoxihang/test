<?php


namespace app\application\combo\lib\Item\Burger;


class VegBurger extends Burger
{

    /**
     * 食物名称
     * @return mixed
     */
    public function name(): string
    {
        return '素汉堡包';
    }

    /**
     * 食物价格
     * @return float
     */
    public function price(): float
    {
        return 22.50;
    }
}