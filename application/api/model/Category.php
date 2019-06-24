<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 14:43
 */

namespace app\api\model;


class Category extends BaseModel
{

    protected $hidden=['delete_time','update_time'];

    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }


}