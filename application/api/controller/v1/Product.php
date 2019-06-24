<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 13:48
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;

class Product
{

    public function getRecent($count=15){
        (new Count())->goCheck();
        $products=ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }

        $products->hidden(['summary']);

        return $products;

    }

}