<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 9:10
 */

namespace app\api\model;


class ProductImage extends BaseModel
{

    protected $hidden=['img_id','delete_time','product_id'];

    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }

}