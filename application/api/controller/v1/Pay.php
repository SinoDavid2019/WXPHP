<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/27
 * Time: 16:16
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;

class Pay extends BaseController
{
    protected $beforeActionList=[
        'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];

    public function getPreOrder($id=''){
        (new IDMustBePositiveInt())->goCheck();


    }

}