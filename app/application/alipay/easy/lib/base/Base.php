<?php


namespace app\application\alipay\easy\lib\base;


use Alipay\EasySDK\Kernel\Factory;
use app\application\alipay\easy\lib\AliBase;

abstract class Base extends AliBase
{
    protected $base_factory = false;

    protected function getBase()
    {
        if($this->base_factory == false){
            $this->base_factory = Factory::base();
        }
        return $this->base_factory;
    }
}