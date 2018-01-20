<?php
namespace app\weixin\controller;

use app\admin\model\System as myModel;
use app\member\model\Member;
use think\Db;
use think\Controller;

class Welogin extends Controller
{
    
    function login() {
        //获取APPID和appsecret
        $wx = new myModel();
        $id = input('get.id')?:'1';
        $wx = myModel::get($id) ?: abort(404);
        //获取类型
        $type = input('get.type');
        
        $appid=$wx['wx_appid'];
		//$appid='wx27a61dd8528b2b26';
        //$request = Request::instance();
		if($type=='info'){
			$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode('http://'.$_SERVER['SERVER_NAME'].'/weixin/welogin/infologin').'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
		}else{
			$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode('http://'.$_SERVER['SERVER_NAME'].'/weixin/welogin/baselogin').'&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
		}
        $this->redirect($url);
        //return $this->success('跳转成功', $url);
    }
    //获取登陆登陆
	function baselogin() {
		$code = input('get.code');
        //获取APPID和appsecret
        $id = input('get.id')?:'1';
        $wx = new myModel();
        $wx = myModel::get($id) ?: abort(404);
		$appid =$wx['wx_appid'];
		$secret =$wx['wx_appsecret'];
        
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
		$res= \my::http_curl($get_token_url);
		$json_obj = json_decode($res,true);
        $weixin= \app\weixin\model\WxUser::get_userinfo($json_obj['openid']);
        $member= \app\member\model\Member::where('openid',$json_obj['openid'])->find();
        
        //设置已登录
        if($member){
            session('member', $member);
            $url = session('before_login') ?: url('index/index');
        }elseif($weixin and !$member){
            session('weixin', $json_obj['openid']);
            $url="/weixin/welogin/bangding";
            $this->redirect($url);
        }
        $this->redirect($url);
        //return $weixin['nickname'];
	}
    //微信绑定
	function bangding() {
		if (request()->isPost()) {
            $username = input('post.username') ?: \my::error('请输入用户名');
            $password = input('post.password') ?: \my::error('请输入密码');

            $member = \app\member\model\Member::get([
                'username' => $username
            ]) ?: \my::error('用户名不存在');

            if ($member->setPasswordAttr($password) !== $member['password'])
                \my::error('密码错误');
            //判断是否绑定
            if($member['openid']!=''){
                \my::error('该用户已绑定微信');
            }
            $member = $member->toArray();
            unset($member['password']);
            session('member', $member);
            Member::where('uid',$member['uid'])->update(['lasttime'=>time(),'openid'=>session('weixin')]);
            $url = session('before_login') ?: url('index/index');
            return $this->success('登录成功！', $url);
        }

        return view();
        
	}
    
}