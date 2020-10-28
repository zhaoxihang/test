<?php


namespace app\home\controller;

use app\application\abstractFactory\FactoryProducer;
use app\application\combo\lib\MealBuilder;
use app\application\factory\lib\ColorFactory;
use app\application\factory\lib\ShapeFactory;
use app\calculator\Operator;
use app\validate\Calculation;
use think\exception\ValidateException;
class Index
{
    public function calculation(){
        $param = input();
        $param['num_one'] = 1;
        $param['num_two'] = 2;
        $param['operator'] = 4;

        //vaildata 验证必传
        try {
            validate(Calculation::class)->check($param);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            dump($e->getError());die;
        }
        $operator = new Operator($param);
        $number = $operator->getResult();
        return $number;
    }

    /**
     * 建造者模式：以套餐为例子
     */
    public function test(){
        $meal = MealBuilder::prepareVegMeal();
        $combo = $meal->showItems();
        trace($combo,'套餐');
        echo $combo;
    }

    /**
     * 工厂模式：以图形和颜色为例子
     */
    public function factory(){
        $shapeFactory = new ShapeFactory();
        $shape = $shapeFactory->getShape('Circle');
        echo $shape->draw()."</br>";
        $colorFactory = new ColorFactory();
        $color = $colorFactory->getColor('Red');
        echo $color->fill();
    }

    /**
     * 抽象工厂：以上述两个工厂为例子
     * 就包了一层，不知道有什么用
     */
    public function abstractFactoryDemo(){
        $shapeFactory = FactoryProducer::getFactory('Shape');
        $shape = $shapeFactory->getShape('Circle');
        echo $shape->draw()."</br>";
        $colorFactory = FactoryProducer::getFactory('Color');
        $color = $colorFactory->getColor('Red');
        echo $color->fill();
    }

    public function index($a){
        return $a;
    }
}