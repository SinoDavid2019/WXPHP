<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/21
 * Time: 11:29
 */

namespace app\api\model;


class BannerItem extends BaseModel
{

    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}