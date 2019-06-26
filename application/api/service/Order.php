<?php
/**
 * Created by PhpStorm.
 * User: weihl
 * Date: 2019/6/26
 * Time: 21:05
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    protected $oProducts;

    protected $products;

    protected $uid;

    public function place($uid,$oProducts){
        $this->oProducts=$oProducts;
        $this->products=$this->getProductsByOrder($oProducts);
        $this->uid=$uid;
    }

    private function getOrderStatus(){

        $status=[
            'pass'=>true,
            'orderPrice'=>0,
            'pStatusArray'=>[]
        ];

        foreach ($this->oProducts as $oProduct){

            $pStatus=$this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);

            if(!$pStatus['haveStock']){
                $status['pass']=false;
            }

            $status['orderPrice']+=$pStatus['totalPrice'];
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