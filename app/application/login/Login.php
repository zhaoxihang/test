<?php


namespace app\application\login;


use app\application\login\login\LoginBase;

class Login
{
    static $instance;

    /**
     * @param $class_name
     * @param $web_name
     * @return LoginBase
     */
    static function getInstance($class_name = false,$web_name = false)
    {
        if (empty(static::$instance[$class_name])) {
            $class_name = $class_name?parse_name($class_name, 1):'General';
            $class = __NAMESPACE__ . "\\Login\\" . $class_name . "Login";
            if (class_exists($class)) {
                static::$instance[$class_name] = new $class($web_name);
            } else {
                throw new \RuntimeException('Login for Method:'.$class_name.' Nothingness!', 40004);
            }
        }
        return static::$instance[$class_name];
    }
}