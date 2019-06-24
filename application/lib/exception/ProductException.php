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
    protected $httpCode=404;


    protected $message='未找到查询的商品信息';

    protected $code=20000;

}