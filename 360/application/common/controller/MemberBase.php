<?php
namespace app\common\controller;

use think\Controller;

class MemberBase extends Controller{

    public function __construct(){
        parent::__construct();

        $member = session('member');

        if (!$member) {
            session('before_login', request()->url());
            //判断是否微信浏览器
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
                $this->redirect('/weixin/welogin/login');
            }else{
                $this->redirect('/member/login/index/');
            }
        }
        
        //定义USER_ID
        define('U_ID', $member['uid']);
        define('SHOP_ID', $member['shop_id']);

    }


}