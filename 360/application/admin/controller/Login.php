<?php

namespace app\admin\controller;

use app\admin\model\User;
use think\Controller;

class Login extends Controller
{
    //电脑端登陆
    function index() {
        if (request()->isPost()) {
            $username = input('post.username') ?: \my::error('请输入用户名');
            $password = input('post.password') ?: \my::error('请输入密码');

            $user = User::get([
                'username' => $username
            ]) ?: \my::error('用户名错误');

            if ($user->setPasswordAttr($password) !== $user->password)
                \my::error('密码错误');


            if (empty($user->Role)) {
                \my::error('你的角色已被删除。');
            }

            $user = $user->toArray();
            unset($user['password']);

            session('user', $user);

            $url = session('before_login') ?: url('index/index');
            return $this->success('登录成功！', $url);
        }

        return view();
    }


    function logout() {
        session('user', null);
        $this->redirect('index');
    }

}