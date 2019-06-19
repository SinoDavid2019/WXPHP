<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 21:35
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule=[
        'name'=>'require|max:10',
        'email'=>'email'
    ];
}