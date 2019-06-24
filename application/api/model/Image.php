<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/21
 * Time: 13:41
 */

namespace app\api\model;


class Image extends BaseModel
{

    protected $hidden=['id','from','update_time','delete_time'];

    public function getUrlAttr($value,$data){

       return $this->prefixImgUrl($value,$data);

    }

}