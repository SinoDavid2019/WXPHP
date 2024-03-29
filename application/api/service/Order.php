<?php
/**
 * Created by PhpStorm.
 * User: weihl
 * Date: 2019/6/26
 * Time: 21:05
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;

use app\api\model\OrderProduct as OrderProductModel;
use think\Db;

class Order
{
    protected $oProducts;

    protected $products;

    protected $uid;

    public function place($uid,$oProducts){
        $this->oProducts=$oProducts;
        $this->products=$this->getProductsByOrder($oProducts);
        $this->uid=$uid;

        $status=$this->getOrderStatus();
        if(!$status['pass']){
          $status['order_id']=-1;
          return $status;
        }

        $snapOrder=$this->snapOrder($status);
        $order=$this->createOrder($snapOrder);

        $order['pass']=true;

        return $order;



    }

    /**
     * 生成订单
     * @param $snap
     * @return array
     * @throws \Exception
     */
    private function createOrder($snap){
        Db::startTrans();//开启数据库事务

       try{

           $orderNo=self::makeOrderNo();
           $order=new OrderModel();
           $order->user_id=$this->uid;

           $order->order_no = $orderNo;
           $order->total_price = $snap['orderPrice'];
           $order->total_count = $snap['totalCount'];
           $order->snap_img = $snap['snapImg'];
           $order->snap_name = $snap['snapName'];
           $order->snap_address = $snap['snapAddress'];
           $order->snap_items = json_encode($snap['pStatus']);
           $order->save();

           $orderID = $order->id;
           $create_time = $order->create_time;

           foreach ($this->oProducts as &$p){

               $p['order_id']=$orderID;

           }

           $orderProduct=new OrderProductModel();

           $orderProduct->saveAll($this->oProducts);

           Db::commit();//提交数据库事务

           return [
               'order_no' => $orderNo,
               'order_id' => $orderID,
               'create_time' => $create_time
           ];

       }catch (\Exception $exception){

           Db::rollback();//如出现异常，回滚事务
           throw $exception;
       }

    }

    /**
     * 生成订单号
     * @return string
     */
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2019] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    /**
     * 检测订单库存量
     * @param $orderID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkOrderStock($orderID){

        $oProducts=OrderProduct::where('order_id','=',$orderID)->select();

        $this->oProducts=$oProducts;

        $this->products=$this->getProductsByOrder($oProducts);

        $status=$this->getOrderStatus();

        return $status;

    }

    /**
     * 订单快照
     */
    private function snapOrder($status){



        $snap=[
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatus'=>[],
            'snapAddress'=>null,
            'snapName'=>'',
            'snapImg'=>''
        ];

        $snap['orderPrice']=$status['orderPrice'];
        $snap['totalCount']=$status['totalCount'];
        $snap['pStatus']=$status['pStatusArray'];
        $snap['snapAddress']=json_encode($this->getUserAddress());

        $snap['snapName']=(count($this->products)>1)?$this->products[0]['name'].'等':$this->products[0]['name'];

        $snap['snapImg']=$this->products[0]['main_img_url'];

        return $snap;


    }

    private function getUserAddress(){
        $userAddress=UserAddress::where('user_id','=',$this->uid)->find();
        if(!$userAddress){
            throw new UserException([
                'message'=>'用户收货地址不存在，下单失败',
                'code'=>60001
            ]);
        }

        return $userAddress->toArray();
    }

    private function getOrderStatus(){

        $status=[
            'pass'=>true,
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatusArray'=>[]
        ];

        foreach ($this->oProducts as $oProduct){

            $pStatus=$this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);

            if(!$pStatus['haveStock']){
                $status['pass']=false;
            }

            $status['orderPrice']+=$pStatus['totalPrice'];
            $status['totalCount']+=$pStatus['count'];
            array_push($status['pStatusArray'],$pStatus);

        }

        return $status;

    }

    private function getProductStatus($oPID,$oCount,$products){

        $pIndex=-1;
        $pStatus=[
            'id'=>null,
            'haveStock'=>false,
            'count'=>0,
            'name'=>'',
            'totalPrice'=>0
        ];

        for($i=0;$i<count($products);$i++){
            if($oPID==$products[$i]['id']){
                $pIndex=$i;
            }
        }

        if($pIndex==-1){
            throw new OrderException([
                'message'=>'id为'.$oPID.'商品不存在，创建订单失败'
            ]);
        }else{

            $product=$products[$pIndex];
            $pStatus['id']=$product['id'];
            $pStatus['count']=$oCount;
            $pStatus['name']=$product['name'];
            $pStatus['totalPrice']=$product['price']*$oCount;
            if($product['stock']-$oCount>=0){
                $pStatus['haveStock']=true;
            }


        }

        return $pStatus;

    }

    private function getProductsByOrder($oProducts){

        $oPIDs=[];

        foreach ($oProducts as $item){
            array_push($oPIDs,$item['product_id']);
        }

        $products=Product::all($oPIDs)->visible(['id','price','stock','name','main_img_url'])->toArray();

        return $products;



    }

}