<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 10:37
 */

namespace app\lib\exception;


class WxChatException extends BaseException
{

    public $httpCode=400;

    public $message='微信服务器接口调用失败';

    public $code=999;
}