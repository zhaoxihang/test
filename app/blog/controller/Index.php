<?php


namespace app\blog\controller;


use app\application\logic\JWTLogic;
use app\application\login\login\LoginBase;

class Index
{
    function index(){
        $param = input();
        $login = new LoginBase('blog');
        json_data($login->login());
    }
}