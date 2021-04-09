<?php
declare (strict_types = 1);

namespace app\model;

use app\application\error\ErrorMsg;
use app\blog\validate\CreateUser;
use think\exception\ValidateException;
use think\Model;

/**
 * @mixin \think\Model
 */
class User extends Model
{
    const DEFAULT_PASSWORD = 123456;

    static function createUser($data)
    {
        $data['password'] = static::getPassword($data['password']);
        try {
            validate(CreateUser::class)->check($data);
        } catch (ValidateException $e) {
            //  增加错误信息机制 验证失败 输出错误信息
            ErrorMsg::setErrorMsg($e->getError());
            return false;
        }
        $model = static::getModelForMobileAndPass($data['mobile']);
        if(!$model || $model->isEmpty()){
            return parent::create($data);
        }
        ErrorMsg::setErrorMsg('手机号已注册');
        return false;
    }

    static function getPassword($string = false): string
    {
        $string = $string?:static::DEFAULT_PASSWORD;

        return md5($string.'blog');
    }

    /**
     * 根据主键查询
     * @param $id
     * @return array|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    static function getModelById($id){
        return parent::find($id);
    }

    static function getModelForMobileAndPass($mobile = false , $pass = false,$user_id = false){
        $where = [];
        if(!$mobile && !$pass && !$user_id){
            return false;
        }
        if($mobile){
            $where['mobile'] = $mobile;
        }

        if($pass){
            $where['password'] = static::getPassword($pass);
        }

        if($user_id){
            $where = ['id'=>$user_id];
        }

        return parent::where($where)->find();
    }


}
