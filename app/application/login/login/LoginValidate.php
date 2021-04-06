<?php


namespace app\application\login\login;


class LoginValidate
{
    static function validate_mobile_password($mobile,$password):bool
    {
        return true;
    }

    static function validate_mobile_verification($mobile,$verification):bool
    {
        return true;
    }

    static function validate_mobile_verification_or_password($mobile,$verification,$password):bool
    {
        if($verification){
            return static::validate_mobile_verification($mobile,$verification);
        }
        return static::validate_mobile_password($mobile,$password);
    }
}