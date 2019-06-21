<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/20
 * Time: 10:13
 */

namespace app\api\model;


use think\Db;

class Banner extends BaseModel


{

    protected $hidden=['delete_time','update_time'];

    public  function items(){
        return $this->hasMany('banner_item','banner_id','id');
    }

    public  static function getBannerByID($id){

       //$result=Db::query('select * from banner_item where banner_id=?',[$id]);
        $result=Db::table('banner_item')->where('banner_id','=',$id)->select();
       return $result;

    }

}