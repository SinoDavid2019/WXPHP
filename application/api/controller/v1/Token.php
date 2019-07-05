<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 8:36
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;

/**
 * 客户端获取token
 * Class Token
 * @package app\api\controller\v1
 */
class Token
{
    public function getToken($code=''){

        (new TokenGet())->goCheck();
        $ut=new UserToken($code);
        $token=$ut->get();

        return [
            'token'=>$token
        ];


    }

    public function verifyToken($token=''){
        if(!$token){
            throw new ParameterException([
                'message'=>'token不能为空'
            ]);
        }

        $valide=TokenService::verifyToken($token);

        return [
            'isValid'=>$valide
        ];
    }

}