<?php


namespace app\blog\controller;


use app\application\login\Login;

class Index
{
    function index(){
        $login = Login::getInstance(false,'blog');
        json_data($login->login());
    }
}