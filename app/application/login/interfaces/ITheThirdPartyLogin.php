<?php


namespace app\application\login\interfaces;


interface ITheThirdPartyLogin
{
    /**
     * 获取第三方标识
     * @param $param
     * @return mixed
     */
    function getThirdPartUserId($param);

    /**
     * 绑定第三方用户
     * @return mixed
     */
    function bindingThirdPartyUsers();
}