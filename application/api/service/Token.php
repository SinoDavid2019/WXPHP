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

    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            }
            else{
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkUID){

        if(!$checkUID){
            throw new Exception('检测UID时必须传入一个被检测的UID');
        }

        $currentOperateUID=self::getCurrentUID();

        if($currentOperateUID==$checkUID){
            return true;
        }

        return false;

    }





}