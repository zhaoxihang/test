<?php
use think\facade\Route;

//测试路由
Route::get('test','Index/test');
//工厂模式
Route::get('factory','Index/factory');
//抽象工厂
Route::get('abstractFactoryDemo','Index/abstractFactoryDemo');
//计算器
Route::get('calculation/:num_one/:num_two/:operator','Index/calculation');
