<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 15:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use think\Controller;

class Order extends BaseController
{

    protected $beforeActionList=[
        'checkExclusiveScope'=>['only'=>'placeOrder']
    ];

    public function placeOrder(){

    }


}