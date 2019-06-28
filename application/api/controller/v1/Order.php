<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 15:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;

use app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use \app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

/**
 * 订单类控制器
 * Class Order
 * @package app\api\controller\v1
 */
class Order extends BaseController
{

    protected $beforeActionList=[
        'checkExclusiveScope'=>['only'=>'placeOrder'],
        'checkPrimaryScope'=>['only'=>'getDetail,getSummaryByUser']
    ];

    public function getSummaryByUser($page=1,$size=15){

        (new PagingParameter())->goCheck();
        $uid=TokenService::getCurrentUID();

        $pagingOrders=OrderModel::getSummaryByUser($uid,$page,$size);
        if($pagingOrders->isEmpty()){
            return [
                'data'=>[],
                'current_page'=>$pagingOrders->currentPage()
            ];
        }else{
            $data=$pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
            return [
                'data'=>$data,
                'current_page'=>$pagingOrders->currentPage()
            ];
        }


    }

    public function getDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail=OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }

        return $orderDetail->hidden(['prepay_id']);
    }

    public function placeOrder(){

        (new OrderPlace())->goCheck();

        $products=input('post.products/a');
        $uid=TokenService::getCurrentUID();

        $order=new OrderService();

        $status=$order->place($uid,$products);

        return $status;

    }


}