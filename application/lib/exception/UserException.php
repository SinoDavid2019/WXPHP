<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 11:44
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $httpCode=404;

    public $message='此用户不存在';

    public $code=60000;

}