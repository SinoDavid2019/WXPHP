<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 13:18
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $httpCode=401;

    public $message='Token已过期或Token无效';

    public $code=10001;

}