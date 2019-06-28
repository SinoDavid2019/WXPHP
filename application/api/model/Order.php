<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/27
 * Time: 11:27
 */

namespace app\api\model;


class Order extends BaseModel
{

    protected $hidden=['update_time','delete_time'];

    protected $autoWriteTimestamp=true;

    public function getSnapItemsAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid,$page,$size){
        $pagingData=self::where('user_id','=',$uid)
            ->order('create_time','desc')
            ->paginate($size,true,['page'=>$page]);

        return $pagingData;
    }

}