<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/26
 * Time: 16:09
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends  Controller
{

    /**
     * User级别权限
     * @throws \app\lib\exception\TokenException
     */
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    /**
     * 用户专有权限
     * @throws \app\lib\exception\TokenException
     */
    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }


    /**
     * Super级别权限
     * @throws \app\lib\exception\TokenException
     */
    protected function checkSuperScope(){
        TokenService::needSuperScope();
    }




}