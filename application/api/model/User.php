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
    public static function getUserByOpenID($openid){
        return self::where('openid',$openid)->find();
    }

}