<?php


namespace app\blog\controller;


use app\application\logic\JWTLogic;

class Index
{
    function index(){
        $token = JWTLogic::createToken();
        return $token;
    }
}