<?php


namespace app\application\prototype;


class BarBookPrototype extends BookPrototype
{

    protected $category = 'Bar';

    // 对引用执行深复制
    public function __clone()
    {

    }
}