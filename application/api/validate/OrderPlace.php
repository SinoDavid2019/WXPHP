<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 16:36
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{

    protected $rule=[
        'products'=>'checkProducts'
    ];

    protected $sigleRule=[
        'product_id'=>'require|isPositiveInteger',
        'count'=>'require|isPositiveInteger'
    ];

    protected function checkProducts($values){

        if(empty($values)){
            throw new ParameterException([
                'message'=>'商品列表不能为空'
            ]);
        }
        if(!is_array($values)){
            throw new ParameterException([
                'message'=>'商品参数错误，请检查'
            ]);
        }

        foreach ($values as $value){
            $this->checkProduct($value);
        }

        return true;

    }

    protected function checkProduct($value){
        $validate=new BaseValidate($this->sigleRule);
        $result=$validate->check($value);
        if(!$result){
            throw new ParameterException([
                'message'=>'商品参数错误'
            ]);
        }

    }



}