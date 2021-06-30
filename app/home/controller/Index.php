<?php


namespace app\home\controller;

use app\application\abstractFactory\FactoryProducer;
use app\application\alipay\easy\lib\base\image\Upload;
use app\application\alipay\easy\tools\config;
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
use app\human\Men;
use app\validate\Calculation;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\View;
use WechatPayment\WechatBasePaymentScore;

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

    /**
     * 原型模式
     */
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

    /**
     * 依赖注入
     */
    public function testInvoke(){
//        $bar = new Bar();
//        $foo = new Foo($bar);

        bind('Foo', 'app\application\dependency_injection\Foo');
        $foo = app('Foo');
        dd($foo);
    }


    public function index(){
        return 123456;
    }

    public function worker(){
        View::assign('fid',10);
        View::assign('tid',20);
        return View::fetch();
    }

    public function wxscore(){
        $mch_id = '商户id';
        //商户v3秘钥
        $key = '商户v3秘钥';
        //商户秘钥（区别上一条）
        $api_key = '商户秘钥';
        //获取服务ID
        $service_id = '获取服务ID';
        //商户序列号
        $service_no = '商户序列号';
        //小程序appid
        $appid = '小程序appid';
        //创建订单回调地址
        $notify_url = '创建订单回调地址';
        $apiclient_key = 'apiclient_key';
        $config = compact('mch_id','key','api_key','service_id','service_no','appid','notify_url','apiclient_key');
        $wechat = WechatBasePaymentScore::getInstance($config);
        //服务信息
        $resource['service_introduction'] = '123';
        //商户服务订单号
        $resource['out_order_no'] = 'a' . time() . rand(1000, 9999);
        //【先享模式】（评估不通过不可使用服务）可填名称为 ESTIMATE_ORDER_COST：预估订单费用
        $resource['risk_fund']['name'] = 'DEPOSIT';
        //风险金额
        $resource['risk_fund']['amount'] = 20*10;
        $a = $wechat->run($resource);
        dd($a);
    }

    function setCache(){
        dump(Cache::set('config',['123','456'],3600));
    }

    function getCache(){
        dump(Cache::get('config'));
    }

    function set_goods_list(){
        //商品1523，16点结束
        $goods_id = '1523';
        Cache::set('goods_'.$goods_id,range(1,100),new \DateTime('2021-03-30 16:00:00'));
    }

    function upload_img(){
        $config = config::getConfig();
        $factory = new Upload($config);
        $result = $factory->run(['image_name'=>'aaaa','image_file'=>'image_file']);
        dump($result);
    }

    function chain_of_genes(){
        $men = new Men();
        dump($men);
    }

}