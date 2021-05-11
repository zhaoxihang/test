<?php


namespace app\application\alipay\easy\lib\base\image;


use app\application\alipay\easy\lib\base\Base;

abstract class Image extends Base
{
    function getImage(){
        return $this->getBase()->image();
    }
}