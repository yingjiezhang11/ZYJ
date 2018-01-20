<?php

namespace app\weixin\model;

use app\admin\model\System as myModel;
use app\common\model\BaseModel;
use think\Db;
class WxUser extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'subscribe_time' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        //$query->where('system.id', '1');
    }

    static function option() {
        $arr = self::column('name', 'id');
        return \my::option($arr);
    }
    //获取微信ACCESSTOKEN
    static function accesstoken($id){
        //
        $wx = new myModel();
        $id = $id?:'1';
        $wx = myModel::get($id) ?: abort(404);
        $appid=$wx['wx_appid'];
        $secret =$wx['wx_appsecret'];
        //判断accesstoken是否过期
        if($wx['extime']<=time()){
            $get_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
			$res= \my::http_curl($get_token_url);
			$at_json = json_decode($res,true);
            $info = array();
            $info['accesstoken'] = $at_json['access_token'];
            $info['extime'] = time()+$at_json['expires_in']-600;
            $wx->save($info,['id'=>$id]);
        }
        return $wx['accesstoken'];
        
    }
    //获取用户基本信息
    static function get_userinfo($openid){
        //查询是否已经有信息
        $weixin=Db::table('wx_user')->where('openid',$openid)->find();
        if($weixin['openid']==''){
            //获取accesstoken
            $accesstoken= \app\weixin\model\WxUser::accesstoken($id);
            $get_token_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$accesstoken.'&openid='.$openid.'&lang=zh_CN';
            $res=\my::http_curl($get_token_url);
            $userinfo = json_decode($res,true);
            //判断是否关注
            $info=array();
            $info['openid'] = $userinfo['openid'];
            $info['nickname'] = $userinfo['nickname'];
            $info['sex'] = $userinfo['sex'];
            $info['province'] = $userinfo['province'];
            $info['city'] = $userinfo['city'];
            $info['country'] = $userinfo['country'];
            $info['subscribe_time'] = $userinfo['subscribe_time'];
            $info['subscribe'] = $userinfo['subscribe'];
            $info['headimgurl'] = $userinfo['headimgurl'];
            $info['addtime'] = time();
            if($info['openid']<>''){
                Db::table('wx_user')->insert($info);
            }
            $weixin=Db::table('wx_user')->where('openid', $openid)->find();
        }elseif(time()-$weixin['addtime']>=604800){//超过7天，刷新资料
            //获取accesstoken
            $accesstoken= \app\weixin\model\WxUser::accesstoken($id);
            $get_token_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$accesstoken.'&openid='.$openid.'&lang=zh_CN';
            $res=\my::http_curl($get_token_url);
            $userinfo = json_decode($res,true);
            //判断是否关注
            $info=array();
            $info['openid'] = $userinfo['openid'];
            $info['nickname'] = $userinfo['nickname'];
            $info['sex'] = $userinfo['sex'];
            $info['province'] = $userinfo['province'];
            $info['city'] = $userinfo['city'];
            $info['country'] = $userinfo['country'];
            $info['subscribe_time'] = $userinfo['subscribe_time'];
            $info['subscribe'] = $userinfo['subscribe'];
            $info['headimgurl'] = $userinfo['headimgurl'];
            $info['addtime'] = time();
            if($info['openid']<>''){
                Db::table('wx_user')->insert($info);
            }
            $weixin=Db::table('wx_user')->where('openid', $openid)->find();
        }
        return $weixin;
    }
}