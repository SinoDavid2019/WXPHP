<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/21
 * Time: 14:48
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{

    protected function prefixImgUrl($value,$data){
        if($data['from']==1){
            return config('setting.img_prefix').$value;
        }else{
            return $value;
        }
    }

}