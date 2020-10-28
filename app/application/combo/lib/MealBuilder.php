<?php


namespace app\application\combo\lib;


use app\application\combo\lib\Item\Burger\ChickenBurger;
use app\application\combo\lib\Item\Burger\VegBurger;
use app\application\combo\lib\Item\Drink\Coke;
use app\application\combo\lib\Item\Drink\Pepsi;

class MealBuilder
{
    /**
     * 准备素食套餐
     * @return Meal
     */
    static public function prepareVegMeal():Meal {
        $meal = new Meal();
        $Burger = new VegBurger();
        $meal->addItem($Burger);
        $drink = new Coke();
        $meal->addItem($drink);
        return $meal;
    }

    /**
     * 准备肉食套餐
     * @return Meal
     */
    static public function prepareNonVegMeal():Meal {
        $meal = new Meal();
        $Burger = new ChickenBurger();
        $meal->addItem($Burger);
        $drink = new Pepsi();
        $meal->addItem($drink);
        return $meal;
    }
}