<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/27
 * Time: 16:27
 */

namespace app\api\service;


use think\Exception;

class Pay
{

    protected $orderID;

    protected $orderNO;

    function __construct($orderID)
    {
        if(!$orderID){
            throw new Exception('订单号不能为空');
        }

        $this->orderID=$orderID;

    }

    public function pay(){

    }

}