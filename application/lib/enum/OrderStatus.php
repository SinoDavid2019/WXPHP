<?php
/**
 * Created by PhpStorm.
 * User: weihl
 * Date: 2019/6/27
 * Time: 19:41
 */

namespace app\lib\enum;


class OrderStatus
{
    //待支付
    const UNPAID=1;

    //已支付
    const PAID=2;

    //已发货
    const DELIVERED=3;

    //已支付，但库存不足
    const PAID_BUT_OUT_OF=4;
}