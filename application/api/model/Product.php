<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 9:23
 */

namespace app\api\model;


class Product extends BaseModel
{

    protected $hidden = ['delete_time', 'create_time', 'update_time', 'pivot'];

    public function getMainImgUrlAttr($value, $data)
    {

        return $this->prefixImgUrl($value, $data);

    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

}