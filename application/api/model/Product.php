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

    public function images(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    public static function getProductsByCategoryID($categoryID){
        $products=self::where('category_id','=',$categoryID)->select();
        return $products;
    }

    public static function getProductDetail($id){
        $product=self::with([
            'images'=>function($query){

                $query->with('imgUrl')->order('order','asc');
            }
        ])->with('properties')->where('id','=',$id)->find();
       // $product=self::with(['images.imgUrl','properties'])->where('id','=',$id)->select();
        return $product;
    }

}