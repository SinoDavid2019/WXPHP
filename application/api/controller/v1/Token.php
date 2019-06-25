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

class Token
{
    public function getToken($code=''){

        (new TokenGet())->goCheck();
        $ut=new UserToken($code);
        $token=$ut->get();
        echo $token;
        return [
            'token'=>$token
        ];


    }

}