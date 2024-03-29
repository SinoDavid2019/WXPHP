<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/27
 * Time: 16:16
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

/**
 * 微信支付类控制器
 * Class Pay
 * @package app\api\controller\v1
 */
class Pay extends BaseController
{
    protected $beforeActionList=[
        'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];

    public function getPreOrder($id=''){
        (new IDMustBePositiveInt())->goCheck();

        $pay=new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify(){

        $nofity=new WxNotify();

        $nofity->Handle();

    }

}