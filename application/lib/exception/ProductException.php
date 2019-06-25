<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 13:55
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $httpCode=404;

    public $message='未找到查询的商品信息';

    public $code=20000;

}