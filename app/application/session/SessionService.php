<?php


namespace app\application\session;

use think\facade\Session;

final class SessionService
{
    /**
     * 博客用户id
     */
    const KEY_BLOG_USER_ID = 'blog_user_id';

    /**
     * 错误信息
     */
    const ERROR_MSG = '';

    /**
     * 取值
     * @param $key
     * @return mixed
     */
    static function get($key)
    {
        $ret = Session::get($key);
        trace("get $key value $ret from session:".session_id(), "session");
        return $ret;
    }

    /**
     * 赋值
     * @param $key
     * @param $val
     */
    static function set($key, $val)
    {
        trace("set $key,$val to session:".session_id(), "session");
        Session::set($key, $val);
    }

    /**
     * 删除某个值
     * @param $key
     */
    static function delete($key)
    {
        trace("clear $key from session:".session_id(), "session");
        Session::delete($key);
    }

    /**
     * 取值并删除
     * @param $key
     * @return mixed
     */
    static function pull($key){
        trace("pull $key from session:".session_id(), "session");
        return Session::pull($key);
    }

    /**
     * 清空
     */
    static function clear(){
        Session::clear();
    }

    /**
     * 闪存
     */
    static function flash(){
        Session::flash('name','value');
    }

    /**
     * 获取博客用户id
     * @return mixed
     */
    static function get_blog_user_id(){
        return static::get(static::KEY_BLOG_USER_ID);
    }

    /**
     * 删除博客用户id
     * @return mixed
     */
    static function delete_blog_user_id(){
        static::delete(static::KEY_BLOG_USER_ID);
    }

    /**
     * 存储博客用户id
     * @param $user_id
     */
    static function set_blog_user_id($user_id){
        static::set(static::KEY_BLOG_USER_ID,$user_id);
    }

    /**
     * 存储错误信息
     * @param $msg
     */
    static function set_error_msg($msg){
        static::set(static::ERROR_MSG,$msg);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    static function get_error_msg(){
        return static::get(static::ERROR_MSG);
    }
}