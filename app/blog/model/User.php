<?php
declare (strict_types = 1);

namespace app\blog\model;

use app\application\session\SessionService;
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
            $e->getError();
            SessionService::set_error_msg($e->getError());
            return false;
        }
        $model = static::getModelForMobileAndPass($data['mobile']);
        if(!$model || $model->isEmpty()){
            return parent::create($data);
        }
        SessionService::set_error_msg('手机号已注册');
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

    static function getModelForMobileAndPass($mobile , $pass = false){
        $where = ['mobile'=>$mobile];
        if($pass){
            $where['password'] = static::getPassword($pass);
        }
        return parent::where($where)->find();
    }


}
