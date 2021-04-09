<?php


namespace app\application\login\traits;


use app\model\ThirdPartyAssociation;

trait TheThirdPartyLogin
{


    /**
     * 绑定第三方用户
     * @return bool
     * @throws \Exception
     */
    function bindingThirdPartyUsers(){
        $authCode = $this->getParam('auth_code');
        $ali_pay_id = $this->getThirdPartUserId($authCode);
        if($ali_pay_id){
            //判断第三方用户表是否关联 没关联的做关联 ，已关联的返回true
            return ThirdPartyAssociation::createAssociation($ali_pay_id,$this->getWebName());
        }
        return false;
    }

    /**
     * 获取第三方标识
     * @param $authCode
     * @return bool|mixed|string
     * @throws \Exception
     */
    function getThirdPartUserId($authCode){
        $fun_name = 'get'.$this->getClassName().'Token';
        $result = $this->getLoginLogic()->getLoginService()->$fun_name($authCode);
        if($result){
            return $result->userId;
        }
        return false;
    }
}