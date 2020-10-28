<?php


namespace app\application\combo\Interfaces;

/**
 * 食物条目
 * Interface Item
 * @package app\application\combo\Interfaces
 */
interface Item
{
    /**
     * 食物名称
     * @return mixed
     */
    public function name():string ;

    /**
     * 食物包装
     * @return mixed
     */
    public function packing():Packing;

    /**
     * 食物价格
     * @return float
     */
    public function price():float ;
}