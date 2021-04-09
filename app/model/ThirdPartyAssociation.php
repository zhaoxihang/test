<?php
declare (strict_types = 1);

namespace app\model;

use app\application\error\ErrorMsg;
use app\application\session\SessionService;
use think\Model;

/**
 * @mixin \think\Model
 */
class ThirdPartyAssociation extends Model
{
    /**
     * 创建关联
     * @param $third_user_id
     * @param bool $web_name
     * @return bool|Model
     */
    static function createAssociation($third_user_id,$web_name = false){
        $fun_name = 'get_'.$web_name.'_user_id';
        $user_id = SessionService::$fun_name();
//        $model = static::getAssociationByUserId($user_id);
//        if(!($model || $model->isEmpty())){
//            return $model;
//        }
        $model = static::getAssociation($third_user_id,$web_name);
        if($model || $model->isEmpty()){
            $data = ['user_id'=>$user_id,'third_user_id'=>$third_user_id,'web_name'=>$web_name?:'blog'];
            return parent::create($data);
        }
        ErrorMsg::setErrorMsg('该用户');
        return false;
    }

    static function getAssociation($third_user_id,$web_name){
        $where = ['third_user_id'=>$third_user_id,'web_name'=>$web_name];
        return parent::where($where)->find();
    }



    /**
     * @param $user_id
     * @return array|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    static function getAssociationByUserId($user_id){
        return parent::where(['user_id'=>$user_id])->find();
    }

    static function getAssociationByThirdUserId($third_user_id){
        return parent::where(['third_user_id'=>$third_user_id])->find();
    }

}
