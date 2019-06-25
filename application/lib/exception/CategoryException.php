<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 14:57
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $httpCode=404;

    public $message='未查询到自定的类目数据，请检查参数';

    public $code=50000;

}