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


class Category
{
    public function getAllCategories(){

        $result=CategoryModel::with('img')->select();
        if($result->isEmpty()){
            throw new CategoryException();
        }
        return $result;

    }

}