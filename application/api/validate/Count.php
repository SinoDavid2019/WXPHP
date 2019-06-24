<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 13:49
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule=[
        'count'=>'between:1,15|isPositiveInteger'
    ];

}