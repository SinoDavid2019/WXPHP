<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 15:13
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $httpCode=403;

    public $message='权限不足';

    public $code=10001;

}