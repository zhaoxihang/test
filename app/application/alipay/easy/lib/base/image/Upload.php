<?php


namespace app\application\alipay\easy\lib\base\image;


class Upload extends Image
{
    function run($param)
    {
        return $this->getImage()->upload($param['image_name'],$param['image_file']);
    }
}