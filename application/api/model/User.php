<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 8:50
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address(){
        return self::hasOne('UserAddress','user_id','id');
    }

    public static function getUserByOpenID($openid){
        return self::where('openid',$openid)->find();
    }

}