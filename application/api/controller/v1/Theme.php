<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/24
 * Time: 9:21
 */

namespace app\api\controller\v1;
use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

/**
 * 专题类控制器
 * Class Theme
 * @package app\api\controller\v1
 */
class Theme
{

    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();
        $ids=explode(',',$ids);
        $result=ThemeModel::with('topicImg,headImg')->select($ids);
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $result=ThemeModel::with('headImg,topicImg,products')->find($id);
        if(empty($result)){
            throw new ThemeException();
        }
        return $result;
    }

}