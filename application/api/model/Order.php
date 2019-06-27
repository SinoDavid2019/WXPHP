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

}