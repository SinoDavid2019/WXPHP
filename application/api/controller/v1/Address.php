<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 10:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\service\UserToken;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

/**
 * 用户收获地址控制器
 * Class Address
 * @package app\api\controller\v1
 */
class Address extends BaseController
{

    protected $beforeActionList=[
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getAddressInfo']
    ];


    /**
     * 创建和更新用户收货地址
     */
    public function createOrUpdateAddress(){

        $validate=new AddressNew();
        $validate->goCheck();

        $uid=TokenService::getCurrentUID();
        $user=User::get($uid);

        if(!$user){
            throw new UserException();
        }

        $userAddress=$user->address;

        $data=$validate->getDataByRule(input('post.'));

        if (!$userAddress)
        {
            // 关联属性不存在，则新建
            $user->address()
                ->save($data);
        }
        else
        {
            // 存在则更新
            //fromArrayToModel($user->address, $data);
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系
            // 更新的save来自于模型
            $user->address->save($data);
        }
        return json(new SuccessMessage(),201);


    }


    /**
     * 获取用户地址
     */
    public function getAddressInfo(){
        $uid=UserToken::getCurrentUID();
        $userAddress=UserAddress::where('user_id','=',$uid)->find();
        if(!$userAddress){
            throw new UserException([
                'message'=>'用户地址不存在',
                'code'=>60001
            ]);
        }

        return $userAddress;

    }

}