<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 10:40
 */

namespace app\api\controller\v1;


use app\api\model\User;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;

class Address extends Controller
{

    protected $beforeActionList=[
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    protected function checkPrimaryScope(){
        $scope=TokenService::getCurrentTokenVar('scope');
        if($scope){
            if($scope>=ScopeEnum::user){
                return true;
            }else{
                throw new ForbiddenException();

            }
        }else{
            throw new TokenException();
        }
    }

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
//            fromArrayToModel($user->address, $data);
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系
            // 更新的save来自于模型
            $user->address->save($data);
        }
        return json(new SuccessMessage(),201);


    }

}