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
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

/**
 * 产品类控制器
 * Class Product
 * @package app\api\controller\v1
 */
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

    public function getAllInCategory($id){

        (new IDMustBePositiveInt())->goCheck();

        $products=ProductModel::getProductsByCategoryID($id);

        if($products->isEmpty()){
            throw new ProductException();
        }

        $products->hidden(['summary']);

        return $products;


    }

    public function getOne($id){

        (new IDMustBePositiveInt())->goCheck();

        $product=ProductModel::getProductDetail($id);
        if(empty($product)){
            throw new ProductException();
        }

        return $product;



    }

}