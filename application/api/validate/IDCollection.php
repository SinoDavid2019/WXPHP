<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 10:18
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{

    protected $rule=[
        'ids'=>'require|checkIDs'
    ];

    protected $message=[
        'ids'=>'传入的参数必须是以逗号分隔的正整数'
    ];

    protected function checkIDs($value){
        $values=explode(',',$value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $id){
           if(! $this->isPositiveInteger($id)){
               return false;
           }
        }

        return true;
    }

}