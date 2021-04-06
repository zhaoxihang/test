<?php


namespace app\application\error;


use app\application\session\SessionService;

class ErrorMsg
{
    static function setErrorMsg($msg , $code = false){
        SessionService::set_error_msg($msg);
    }

    static function getErrorMsg(){
        return SessionService::get_error_msg();
    }
}