<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/27
 * Time: 16:27
 */

namespace app\api\service;


use app\lib\enum\OrderStatus;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use \app\api\model\Order as OrderModel;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');//引用第三方API

class Pay
{

    protected $orderID;

    protected $orderNO;

    function __construct($orderID)
    {
        if(!$orderID){
            throw new Exception('订单号不能为空');
        }

        $this->orderID=$orderID;

    }

    public function pay(){

        $this->checkOrderValid();

        $orderService=new Order();
        $status=$orderService->checkOrderStock($this->orderID);

        if(!$status['pass']){
            return $status;
        }

        return $this->makeWxPreOrder($status['orderPrice']);



    }

    private function makeWxPreOrder($totalPrice){

        $openid=Token::getCurrentTokenVar('openid');

        if(!$openid){
            throw new TokenException();
        }

        $wxOrderData=new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url('');

        return $this->getPaySignature($wxOrderData);




    }

    private function getPaySignature($wxOrderData){

        $wxOrder=\WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code']!='SUCCESS'||$wxOrder['result_code']!='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        $this->recordPreOrder($wxOrder);

        $signature=$this->sign($wxOrder);

        return $signature;


    }

    private function sign($wxOrder){
        $jsApiPayData=new \WxPayJsApiPay();

        $jsApiPayData->SetAppid(config(wx.appid));

        $jsApiPayData->SetTimeStamp((string)time());

        $rand=md5(time().mt_rand(0,1000));

        $jsApiPayData->SetNonceStr($rand);

        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);

        $jsApiPayData->SetSignType('MD5');

        $sign=$jsApiPayData->MakeSign();

        $rawValues=$jsApiPayData->GetValues();

        $rawValues['paySign']=$sign;

        unset($rawValues['appId']);

        return $rawValues;

    }

    private function recordPreOrder($wxOrder){

        OrderModel::where('id','=',$this->orderID)->update(['prepay_id'=>$wxOrder['prepay_id']]);


    }



    private function checkOrderValid(){

        $order=OrderModel::where('id','=',$this->orderID)->find();

        if(!$order){
            throw new OrderException();
        }
        if(!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'message'=>'订单与用户不匹配',
                'code'=>10003
            ]);
        }

        if($order->status!=OrderStatus::UNPAID){
            throw new OrderException([
                'message'=>'订单已支付',
                'code'=>80003,
                'httpCode'=>400
            ]);
        }

        $this->orderNO= $order->order_no;

        return true;



    }



}