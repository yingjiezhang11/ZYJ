<?php

namespace app\member\controller;
use app\common\controller\MemberBase;
use app\member\model\Member as myModel;
use app\admin\model\Role;
use think\Db;
use think\Request;
class Member extends MemberBase
{
    //员工管理
    function index() {
        //判断权限
        \my::m_auth('user-list');
        $model = new myModel();

        if ($kw = input('kw')) {
            $model->where("user.realname","like",'%'.$kw.'%');
        }
        $where="shop_id='".SHOP_ID."'";
        $list = $model->where($where)->paginate();

        return view('index', [
            'list' => $list,
        ]);
    }
    //修改员工
    function edit() {
        //判断权限
        \my::m_auth('user-list-auth-edit');
        if (request()->isPost()) {
            $data = Request::instance()->post(false);
            if ($id = input('get.id')) {
                \my::valid('Member.edit', $data);
                $model = myModel::get($id) ?: abort(404);
                $repeat = ['username'=>$data['username'],'uid'=>['<>',$id]];
            }else{
                \my::valid('Member', $data);
                $model = new myModel();
                $repeat = ['username'=>$data['username']];
            }

            //判断用户名，全表
            if (Db::table('member')->where($repeat)->count())
                \my::error('用户名己存在');
            $data['shop_id']= SHOP_ID;
            if(input('get.id')=='1'){
                return $this->success('禁止修改！');
            }else{
                $model->save($data);
                return $this->success('保存成功！', url('member/index'));
            }
            
        }elseif($id = input('get.id')) {
            $model = myModel::get($id) ?: abort(404);
//            return dump($model);
        }
        return view('edit', [
            'editData' => $model,
        ]);
    }
    //用户删除
    function delete() {
        //判断权限
        \my::m_auth('user-list-auth-delete');
        if ($id = input('get.id')) {
            $ret = myModel::destroy($id);
            if ($ret) {
                \my::error('删除成功', url('member/index'));
                //$this->success('删除成功', '');
            }
        }
        \my::error('未知错误');
    }
    // 角色.权限
    function role() {
        \my::m_auth('user-role');
        
        $list = Role::where('type','1')->order('type desc')->paginate();
        return view('role', [
            'list' => $list
        ]);
    }
    // 角色.权限修改
    function role_edit() {
        \my::m_auth('user-role-auth-edit');
        if (request()->isPost()) {
            $data = input('post.');
            $data['shop_id'] = SHOP_ID;
            $data['type'] = '1';
            if (!$data['auth']) {
                $data['auth'] = [];
            }
            if ($id = input('get.id')) {
                $role = Role::get($id) ?: abort(404);
            }else{
                $role = new Role();
            }
            $role->save($data);

            return $this->success('保存成功！', url('member/role'));
        }elseif($id = input('get.id')) {
            $role = Role::get($id) ?: abort(404);
        }
        return view('role_edit', [
            'editData' => $role,
        ]);
    }
    // 角色.权限删除
    function role_delete() {
        \my::m_auth('user-role-auth-delete');
        if ($id = input('get.id')) {
            //$ret = Role::destroy($id);
            if ($ret) {
                $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    // 修改密码
    function password() {
        if (request()->isPost()) {
            $oldPassword = input('post.old_password') ?: \my::error('请输入原密码');
            $newPassword = input('post.new_password') ?: \my::error('请输入新密码');
            $newPassword2 = input('post.new_password2') ?: \my::error('请再次输入新密码');

            if ($newPassword!==$newPassword2) {
                \my::error('两次输入的新密码不一致');
            }
//            $uid = myModel::login();
            $member = myModel::get(U_ID) ?: abort(404);
            $oldPassword = myModel::passwordEncode($oldPassword);

            if ($member['password']!==$oldPassword) {
                \my::error('原密码错误');
            }

            $member['password'] = $newPassword;
            //$member->save();
            //return $this->success('修改成功！', '');
            return $this->success('你想干嘛?密码不能给你改！', '');
        }

        return $this->fetch('password');
    }
}