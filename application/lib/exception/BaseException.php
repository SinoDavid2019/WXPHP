<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 11:05
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //http状态码 404,500
    public $httpCode=400;

    //错误消息
    public $message='参数错误';

    //业务状态码 10001,10002
    public $code=10000;

    public function __construct($params=[])
    {

        if(!is_array($params)){
           return;
            // throw new Exception('参数必须是数组');
        }

        if(array_key_exists('httpCode',$params)){
            $this->httpCode=$params['httpCode'];
        }

        if(array_key_exists('message',$params)){
            $this->message=$params['message'];
        }

        if(array_key_exists('code',$params)){
            $this->code=$params['code'];
        }


    }


}