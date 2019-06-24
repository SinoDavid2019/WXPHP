<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 11:02
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $httpCode=404;

    public $message='所查询的主题不存在，请检查主题id';

    public $code=30000;

}