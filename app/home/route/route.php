<?php
use think\facade\Route;

//测试路由
Route::get('test','Index/test');
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
