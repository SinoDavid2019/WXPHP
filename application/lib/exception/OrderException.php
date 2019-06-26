<?php
/**
 * Created by PhpStorm.
 * User: weihl
 * Date: 2019/6/26
 * Time: 21:36
 */

namespace app\lib\exception;


class OrderException extends BaseException
{

    public $httpCode=404;
    public $message='订单不存在，请检查id';

    public $code=80000;




}