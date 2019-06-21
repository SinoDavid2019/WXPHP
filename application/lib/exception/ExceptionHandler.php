<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 11:00
 */

namespace app\lib\exception;



use think\exception\Handle;
use think\Log;
use think\Request;

/**
 * 重写Handler rander方法 实现自定义异常
 * Class ExceptionHandler
 * @package app\lib\exception
 */
class ExceptionHandler extends Handle
{
    private $httpCode;

    private $message;

    private $code;

    /**
     * 重写Handler rander方法
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(\Exception $e)
    {

        if($e instanceof BaseException){
            $this->code=$e->code;
            $this->httpCode=$e->httpCode;
            $this->message=$e->message;

        }else{

            $switch=config('app_debug');
            if($switch){
                return parent::render($e);
            }else{
                $this->httpCode=500;
                $this->message='服务器内部错误，请联系服务';
                $this->code=999;
                $this->recordErrorLog($e);
            }


        }

        $request=Request::instance();

        $result=[
            'message'=>$this->message,
            'code'=>$this->code,
            'http_url'=>$request->url()
        ];

        return json($result,$this->httpCode);
    }

    /**
     * 将Error级别的错误写入日志
     * @param Exception $exception
     */
    private function recordErrorLog(\Exception $exception){
        Log::init([
            'type'  => 'File',
            'path'  => LOG_PATH,
            'level' => ['error']
        ]);

        Log::record($exception->getMessage(),'error');
    }

}