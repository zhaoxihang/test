<?php


namespace app\application\combo\lib\Item\Drink;


class Pepsi extends Drink
{

    /**
     * 食物价格
     * @return float
     */
    public function price(): float
    {
        return 22.00;
    }

    /**
     * 食物名称
     * @return mixed
     */
    public function name(): string
    {
        return '百世可乐';
    }
}