<?php

namespace app\admin\controller;


use app\common\controller\Base;
use app\admin\model\User as myModel;
use app\member\model\Member;
use think\Db;
use think\Request;

class User extends Base
{
    function index() {
        //判断权限
        \my::auth('user-list');
        $model = new myModel();

        if ($kw = input('kw')) {
            $model->where("user.realname","like",'%'.$kw.'%');
        }
        if (!IS_ADMIN){
            $where="user.id<>'1'";
        }
        $list = $model->where($where)->with('Role')->paginate();

        return view('index', [
            'list' => $list,
        ]);
    }
    
    function edit() {
        //判断权限
        \my::auth('user-list-auth-edit');
        if (request()->isPost()) {
            $data = Request::instance()->post(false);


            if ($id = input('get.id')) {
                \my::valid('User.edit', $data);
                $model = myModel::get($id) ?: abort(404);
                $repeat = ['username'=>$data['username'],'id'=>['<>',$id]];
            }else{
                \my::valid('User', $data);
                $model = new myModel();
                $repeat = ['username'=>$data['username']];
            }

            //判断用户名，全表
            if (Db::name('user')->where($repeat)->count())
                \my::error('用户名己存在');

            $model->save($data);

            return $this->success('保存成功！', url('User/index'));
        }elseif($id = input('get.id')) {
            $model = myModel::get($id) ?: abort(404);
//            return dump($model);
        }
        return view('edit', [
            'editData' => $model,
        ]);
    }

    function delete() {
        //判断权限
        \my::auth('user-list-auth-delete');
        if ($id = input('get.id')) {
            $ret = myModel::destroy($id);
            if ($ret) {
                \my::error('删除成功', url('User/index'));
                //$this->success('删除成功', '');
            }
        }
        \my::error('未知错误');
    }

    function member() {
        //判断权限
        \my::auth('user-member');

        if ($kw = input('kw')) {
            $model->where("member.username","like",'%'.$kw.'%');
        }
        $list = Member::where($where)->paginate();

        return view('member', [
            'list' => $list,
        ]);
    }
    function member_edit() {
        //判断权限
        \my::auth('user-member-auth-edit');
        $id = input('get.id');
        if (request()->isPost()) {
            $data = input('post.');
            //$data['password']=$model['password'];
            Member::save($data);

            return $this->success('保存成功！', url('User/member'));
        }elseif($id = input('get.id')) {
            $model = Member::get($id) ?: abort(404);
        }
        return view('member_edit', [
            'editData' => $model,
        ]);
    }
    public function ajaxGetOne(){
        $id = input('id');
        $return = ['status' => 0];
        if ($id){
            $Model = new myModel();
            $user = $Model::get(['id'=>$id])->getData();
            $return = [
                'status'    =>  1,
                'data'      =>  [
                    'name'  =>  $user['realname'],
                    'post'  =>  $user['title'],
                    'sex'   =>  $user['gender'],
                    'photo' =>  $user['photo']
                ]
            ];
        }
        exit(json_encode($return));
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
            $user = myModel::get(USER_ID) ?: abort(404);

            $oldPassword = myModel::passwordEncode($oldPassword);

            if ($user['password']!==$oldPassword) {
                \my::error('原密码错误');
            }

            $user['password'] = $newPassword;
            $user->save();

            return $this->success('修改成功！', '');
        }

        return view('password');
    }
}