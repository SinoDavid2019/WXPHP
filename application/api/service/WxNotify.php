<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/28
 * Time: 10:40
 */

namespace app\api\service;
use app\api\model\Product;
use app\lib\enum\OrderStatus;
use think\Db;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class WxNotify extends \WxPayNotify
{

    public function NotifyProcess($data, &$msg)
    {
        if($data['result_code']=='SUCCESS'){
            $orderNO=$data['out_trade_no'];
            Db::startTrans();
            try{

               $order= OrderModel::where('order_no','=',$orderNO)->lock(true)->find();
                if($order->status==1){
                    $orderService=new OrderService();
                    $stockStatus=$orderService->checkOrderStock($order->id);
                    if($stockStatus['pass']){

                        $this->updateOrderStatus($order->id,true);
                        $this->reduceStock($stockStatus);
                    }else{
                        $this->updateOrderStatus($order->id,false);
                    }

                }

                Db::commit();

                return true;

            }catch (\Exception $exception){
                Db::rollback();
                Log::record($exception);
                return false;

            }
        }else{
            return true;
        }


    }

    /**
     * 更新库存量
     * @param $stockStatus 库存检测结果数据集
     * @throws \think\Exception
     */
    private function reduceStock($stockStatus){

        foreach ($stockStatus['pStatusArray'] as $sigleStatus){

            Product::where('id','=',$sigleStatus['id'])->setDec('stock',$sigleStatus['count']);


        }

    }

    /**
     * 更新订单状态
     * @param $orderID 订单ID
     * @param $success 订单库存量检测结果标识
     */
    private function updateOrderStatus($orderID,$success){

        $status=$success?OrderStatus::PAID:OrderStatus::PAID_BUT_OUT_OF;

        OrderModel::where('id','=',$orderID)->update(['status'=>$status]);

    }


}