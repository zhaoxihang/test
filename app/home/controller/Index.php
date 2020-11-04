<?php


namespace app\home\controller;

use app\application\abstractFactory\FactoryProducer;
use app\application\combo\lib\MealBuilder;
use app\application\factory\lib\ColorFactory;
use app\application\factory\lib\ShapeFactory;
use app\application\filter\lib\AndCriteria;
use app\application\filter\lib\CriteriaFemale;
use app\application\filter\lib\CriteriaMale;
use app\application\filter\lib\CriteriaSingle;
use app\application\filter\lib\OrCriteria;
use app\application\filter\lib\Person;
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

    /**
     * 过滤器模式
     */
    public function filter(){
        $persons = [];
        $persons[] = new Person('小赵','Male','singleDog');
        $persons[] = new Person('小钱','Female','Married');
        $persons[] = new Person('小孙','Female','singleDog');
        $persons[] = new Person('小李','Male','Married');
        $persons[] = new Person('小周','Male','singleDog');

        $male = new CriteriaMale();
        $female = new CriteriaFemale();
        $single = new CriteriaSingle();

        $singleAndMale = new AndCriteria($single,$male);


        $singleOrFemale = new OrCriteria($single,$female);

        $data = [
            '男人：'=>$male->meetCriteria($persons),
            '女人：'=>$female->meetCriteria($persons),
            '单身男性：'=>$singleAndMale->meetCriteria($persons),
            '单身的和女性'=>$singleOrFemale->meetCriteria($persons)
        ];

       dump($data);
    }


    public function index($a){
        return $a;
    }
}