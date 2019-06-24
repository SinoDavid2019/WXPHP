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
    protected $httpCode=404;

    protected $message='未查询到自定的类目数据，请检查参数';

    protected $code=50000;

}