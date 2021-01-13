<?php


namespace app\application\prototype;

/**
 * 书的原型
 * Class BookPrototype
 * @package app\application\prototype
 */
abstract class BookPrototype
{
    /**
     * @var string
     */
    protected $title;

    protected $category;

    // 对引用执行深复制
    abstract public function __clone();

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }


}