<?php


namespace app\application\combo\lib;

use TencentCloud\Ame\V20190916\Models\Item;

/**
 * 套餐
 * Class Meal
 * @package app\application\combo\lib
 */
class Meal
{
    private $Items = [];

    /**
     * 添加食物
     * @param $item
     */
    public function addItem($item) {
        $this->Items[] = $item;
    }

    /**
     * 获取套餐价格
     * @return float
     */
    public function getCost():float {
        $cost = 0;
        foreach ($this->Items as $v){
            $cost += $v->price();
        }
        return floatval($cost);
    }

    public function showItems(){
        $str = "菜单：</br>";
        foreach ($this->Items as $v){
            $str .= "名称：".$v->name();
            $str .= "包装：".$v->packing()->pack();
            $str .= "价格：".$v->price()."</br>";
        }
        $str .= "总价格：".$this->getCost();
        return $str;
    }
}