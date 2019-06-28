<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 14:43
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

/**
 * 商品类目控制器
 * Class Category
 * @package app\api\controller\v1
 */
class Category
{
    public function getAllCategories(){

        $result=CategoryModel::all([],'img');
        if($result->isEmpty()){
            throw new CategoryException();
        }
        return $result;

    }

}