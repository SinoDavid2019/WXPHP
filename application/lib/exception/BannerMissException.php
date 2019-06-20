<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 11:10
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{

    public $httpCode=404;

    //错误消息
    public $message='请求的Banner不存在';

    //业务状态码 10001,10002
    public $code=40000;

}