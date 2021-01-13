<?php


namespace app\application\prototype;


class FooBookPrototype extends BookPrototype
{

    protected $category = 'Foo';

    // 对引用执行深复制
    public function __clone()
    {

    }
}