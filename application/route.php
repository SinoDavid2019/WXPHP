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

Route::get('api/:version/product/recent','api/:version.product/getRecent');

Route::get('api/:version/product/by_category/:id','api/:version.product/getAllInCategory');

Route::get('api/:version/category/all','api/:version.category/getAllCategories');

Route::post('api/:version/token/user','api/:version.token/getToken');
