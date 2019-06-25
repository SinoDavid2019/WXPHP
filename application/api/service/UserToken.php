<?php
/**
 * Created by PhpStorm.
 * User: sino
 * Date: 2019/6/25
 * Time: 8:49
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use app\lib\exception\WxChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{

    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $loginUrl;

    function __construct($code)
    {
        $this->wxAppID = config('wx.appid');
        $this->wxAppSecret = config('wx.appSecret');
        $this->code = $code;
        $this->loginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        $result = curl_get($this->loginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key和openID时出现异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->precessLoginErr($wxResult);

            } else {
                return $this->grantToken($wxResult);
            }
        }

    }

    private function grantToken($wxResult)
    {

        $openid=$wxResult['openid'];

        $user=UserModel::getUserByOpenID($openid);
        if($user){
            $uid=$user->id;

        }else{
            $uid=$this->newUser($openid);
        }

        $cacheValue=$this->prepareCacheValue($wxResult,$uid);
        $token=$this->saveToCache($cacheValue);

        return $token;

    }

    private function saveToCache($cacheValue){
        $key=self::generateToken();
        $value=json_encode($cacheValue);
        $expire_in=config('setting.token_expire_in');
        $request=cache($key,$value,$expire_in);
        if(!$request){
            throw new TokenException();
        }

        return $key;
    }

    private function prepareCacheValue($wxResult,$uid){
        $cacheValue=$wxResult;
        $cacheValue['uid']=$uid;
        $cacheValue['scope']=16;
        return $cacheValue;

    }

    private function newUser($openid){
        $user=UserModel::create([
            'openid'=>$openid,
        ]);

        return $user->id;
    }

    private function precessLoginErr($wxResult)
    {
        throw new WxChatException([
            'message' => $wxResult['errmsg'],
            'code' => $wxResult['errcode']
        ]);

    }

}