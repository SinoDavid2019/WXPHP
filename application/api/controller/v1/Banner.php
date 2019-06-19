<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 21:08
 */

namespace app\api\controller\v1;


use app\api\validate\TestValidate;
use think\Validate;

class Banner
{

    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id  banner的ID号
     */
    public function  getBanner($id){

        //独立验证
        $data=[
          'name'=>'',
          'email'=>'vendor@qqcom'
        ];

//        $validate=new Validate([
//            'name'=>'require|max:10',
//            'email'=>'email'
//        ]);
        $validate=new TestValidate();


        $result=$validate->batch()->check($data);

        halt($validate->getError());

        //验证器




    }

}