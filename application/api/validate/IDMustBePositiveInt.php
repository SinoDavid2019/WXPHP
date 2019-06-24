<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 8:55
 */

namespace app\api\validate;

class IDMustBePositiveInt extends BaseValidate
{

    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message=[
        'id'=>'id必须是正整数'
    ];



}