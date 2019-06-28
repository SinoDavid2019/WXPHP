<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');

Route::get('api/:version/theme','api/:version.theme/getSimpleList');

Route::get('api/:version/theme/:id','api/:version.theme/getComplexOne');

//Route::get('api/:version/product/recent','api/:version.product/getRecent');
//
//Route::get('api/:version/product/by_category/:id','api/:version.product/getAllInCategory');
//
//Route::get('api/:version/product/:id','api/:version.Product/getOne',[],['id'=>'\d+']);

Route::group('api/:version/product',function (){
    Route::get('/recent','api/:version.product/getRecent');
    Route::get('/by_category/:id','api/:version.product/getAllInCategory');
    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
});

Route::get('api/:version/category/all','api/:version.category/getAllCategories');

Route::post('api/:version/token/user','api/:version.token/getToken');

Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order','api/:version.Order/placeOrder');
Route::get('api/:version/order/by_user','api/:version.Order/getSummaryByUser');
Route::get('api/:version/order/:id','api/:version.Order/getDetail',[],['id'=>'\d+']);

Route::post('api/:version/pay/pre_order','api/:version.Pay/getPreOrder');

Route::post('api/:version/pay/notify','api/:version.Pay/receiveNotify');

