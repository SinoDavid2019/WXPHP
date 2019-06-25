<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 11:25
 */

namespace app\api\service;


class Token
{

    public static function generateToken(){
        $randChars=generateRandChars(32);

        $timeStamp=$_SERVER['REQUEST_TIME'];

        $salt=config('secure.token_salt');

        return md5($randChars.$timeStamp.$salt);
    }



}