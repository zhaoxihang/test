<?php


namespace app\home\controller;

use app\application\abstractFactory\FactoryProducer;
use app\application\combo\lib\MealBuilder;
use app\application\dependency_injection\Bar;
use app\application\dependency_injection\Foo;
use app\application\factory\lib\ColorFactory;
use app\application\factory\lib\ShapeFactory;
use app\application\filter\lib\AndCriteria;
use app\application\filter\lib\CriteriaFemale;
use app\application\filter\lib\CriteriaMale;
use app\application\filter\lib\CriteriaSingle;
use app\application\filter\lib\OrCriteria;
use app\application\filter\lib\Person;
use app\application\objectPool\WorkerPool;
use app\application\prototype\BarBookPrototype;
use app\application\prototype\FooBookPrototype;
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

    /**
     * 对象池模式
     */
    public function objectPoolTestOne()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $worker2 = $pool->get();
        $worker1->run('one');
        $worker2->run('two');
        /**
         * 两个独立的对象
         */
        dump($worker1,$worker2);
    }

    /**
     * 对象池模式
     */
    public function objectPoolTestTwo()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $pool->dispose($worker1);
        $worker2 = $pool->get();
        $worker1->run('one');
        /**
         * 两个是同一个对象
         */
        dump($worker1,$worker2);
    }

    public function prototype()
    {
        $fooPrototype = new FooBookPrototype();
        $barPrototype = new BarBookPrototype();
        $foo_list = [ ];
        $bar_list = [ ];
        for ($i = 0; $i < 5; $i++)
        {
            $book = clone $fooPrototype;
            $book->setTitle('foo book no'.$i);
            $foo_list[] = $book;
        }

        for ($i = 0; $i < 5; $i++)
        {
            $book = clone $barPrototype;
            $book->setTitle('bar book no'.$i);
            $bar_list[] = $book;
        }
    }

    public function testInvoke(){
//        $bar = new Bar();
//        $foo = new Foo($bar);

        bind('Foo', 'app\application\dependency_injection\Foo');
        $foo = app('Foo');
        dd($foo);
    }


    public function index($a){
        return $a;
    }
}