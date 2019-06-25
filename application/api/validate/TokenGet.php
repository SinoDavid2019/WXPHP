<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 8:40
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{

    protected $rule=[
        'code'=>'require|isNotEmpty'
    ];

    protected $message=[
        'code'=>'code不允许为空'
    ];

}