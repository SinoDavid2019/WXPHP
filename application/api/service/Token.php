<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 11:25
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{

    public static function generateToken(){
        $randChars=generateRandChars(32);

        $timeStamp=$_SERVER['REQUEST_TIME'];

        $salt=config('secure.token_salt');

        return md5($randChars.$timeStamp.$salt);
    }

    public static function getCurrentTokenVar($key){

        $token=Request::instance()->header('token');

        $vars=Cache::get($token);

        if(!$vars){
            throw new TokenException();

        }else{
            if(!is_array($vars)){
                $vars=json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('获取的Token变量值不存在');
            }
        }

    }

    public static function getCurrentUID(){

        $uid=self::getCurrentTokenVar('uid');
        return $uid;
    }



}