<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/28
 * Time: 15:25
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{

    protected $rule=[
        'page'=>'isPositiveInteger',
        'size'=>'isPositiveInteger'
    ];

    protected $message=[
        'page'=>'分页参数必须是正整数',
        'size'=>'分页参数必须是正整数'
    ];

}