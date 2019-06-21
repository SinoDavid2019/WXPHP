<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 9:19
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request=Request::instance();
        $param=$request->param();

        $result=$this->batch()->check($param);

        if(!$result){
            $exception=new ParameterException([
                'message'=> is_array($this->error) ? implode(
                    ';', $this->error) : $this->error
            ]);
            throw $exception;
        }else{
            return true;
        }
    }
}