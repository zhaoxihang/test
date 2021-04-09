<?php


namespace app\blog\controller;


use app\application\login\Login;

class Index
{
    function index(){
        $login = Login::getInstance('alipay','blog');
        json_data($login->login());
    }
}