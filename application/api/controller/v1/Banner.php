<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 21:08
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use \app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{

    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id  banner的ID号
     */
    public function  getBanner($id){

       (new IDMustBePositiveInt())->goCheck();
        $banner=BannerModel::getBannerByID($id);
        if(!$banner){
            throw new BannerMissException();
        }

    }

}