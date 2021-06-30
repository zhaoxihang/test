<?php
use think\facade\Route;

//测试路由
Route::get('test','Index/test');
Route::get('worker','Index/worker');
//工厂模式
Route::get('factory','Index/factory');
//抽象工厂
Route::get('abstractFactoryDemo','Index/abstractFactoryDemo');
//过滤器模式
Route::get('filter','Index/filter');
//计算器
Route::get('calculation/:num_one/:num_two/:operator','Index/calculation');
//对象池模式
Route::get('objectOne','Index/objectPoolTestOne');
Route::get('objectTwo','Index/objectPoolTestTwo');
//原型模式
Route::get('prototype','Index/prototype');

//依赖注入
Route::get('testInvoke','Index/testInvoke');

//微信支付分composer测试
Route::get('wxscore','Index/wxscore');

//测试缓存redis
Route::get('set_redis','Index/setCache');
Route::get('get_redis','Index/getCache');

//模拟抢购
/*  现在有商品a  限量100 个 限时20分钟 限购一台 */
/*
 * 一：在抢购开始前以商品id为键写入100条记录，过期时间设置好
 * 二：抢购开始，用户点击下单时从redis内部取出一条记录，并将商品和用户写入订单表
 */
/**
 * 设置redis队列
 */
Route::get('set_goods_list','Index/set_goods_list');
/**
 * 取出商品编号
 */
Route::get('set_goods_list','Index/get_goods_num');

/**
 * 人类基因测试
 */
Route::get("chain_of_genes","Index/chain_of_genes");