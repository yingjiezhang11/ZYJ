<?php

namespace app\member\controller;

use app\member\model\Member;
use think\Controller;

class Login extends Controller
{
    //电脑端登陆
    function index() {
        if (request()->isPost()) {
            $username = input('post.username') ?: \my::error('请输入用户名');
            $password = input('post.password') ?: \my::error('请输入密码');

            $member = \app\member\model\Member::get([
                'username' => $username
            ]) ?: \my::error('用户名不存在');
//            echo $member->setPasswordAttr($password);exit;
            if ($member->setPasswordAttr($password) !== $member['password'])
                \my::error('密码错误');


            //if (empty($member->Role)) {
              //  \my::error('你的角色已被删除。');
            //}

            $member = $member->toArray();
            unset($member['password']);
            session('member', $member);
            Member::where('uid',$member['uid'])->update(['lasttime'=>time()]);
            $url = session('before_login') ?: url('index/index');
            return $this->success('登录成功！', $url);
        }

        return view();
    }
    //注册账号
    function register() {
        if (request()->isPost()) {
            $username = input('post.username') ?: \my::error('请输入用户名');
            $password = input('post.password') ?: \my::error('请输入密码');
            $pwdconfirm = input('post.pwdconfirm') ?: \my::error('请输入密码');
            $mobile = input('post.mobile')?: \my::error('请输入手机号码');
            if ($password!==$pwdconfirm) {
                \my::error('两次输入的新密码不一致');
            }
            //验证用户名和手机号码
            $member = Member::get(['username' => $username]);
            if($member){\my::error('该用户名已存在');}
            $member = Member::get(['mobile' => $mobile]);
            if($member){\my::error('该手机号码已经注册');}
            //验证手机号码
            if(!preg_match("/^1[0-9]{10}$/",$mobile)){\my::error('手机号码格式不对');}
            //保存到数据库
            $data = input('post.');
            $data['role_id'] = '7';//默认用户组
            $data['password']= \app\member\model\Member::passwordEncode($password);
            \app\member\model\Member::insert($data);
            //\my::error($data['password']);
            session('member', $member);

            $url = session('before_login') ?: url('index/index');
            return $this->success('注册成功！');
        }

        return view();
    }


    function logout() {
        session('member', null);
        $this->redirect('index');
    }

}