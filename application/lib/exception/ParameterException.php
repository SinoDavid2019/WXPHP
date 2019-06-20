<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 14:31
 */

namespace app\lib\exception;

/**
 * 通用参数错误
 * Class ParameterException
 * @package app\lib\exception
 */
class ParameterException extends BaseException
{

    public $httpCode=400;

    public $message='参数错误';

    public $code=10000;

}