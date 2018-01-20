<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\admin\model\Column as myModel;
use think\Request;
class Column extends Base
{

    function index() {
        \my::auth('content-list');
        $model = new myModel();
        
        $lists = $model->order('listorder desc,id asc')->column('cname,pid,type,module,listorder','id');
        $lists = $model->peer($lists);
        
        return view('index', [
            'lists' => $lists
        ]);
    }
    //添加栏目
    function add() {
        \my::auth('content-list-auth-add');
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime']=time();
            $data['userid']=USER_ID;
            \my::valid('Column', $data);
            $model = new myModel();
            $model->save($data);
            $this->success('保存成功！', url('Column/index'));
        }
        return $this->fetch('edit');
    }
    //编辑栏目
    function edit() {
        \my::auth('content-list-auth-edit');
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime']=time();
            $data['userid']=USER_ID;
            $id = input('post.id');
            \my::valid('Column', $data);
            $model = new myModel();
            $model->save($data,['id'=>$id]);
            return $this->success('保存成功！', url('Column/index'));
        }elseif($id = input('get.id')) {
            $role = myModel::get($id) ?: abort(404);
        }
        return $this->fetch('edit', [
            'editData' => $role,
        ]);
    }
    //删除栏目
    function delete() {
        \my::auth('content-list-auth-delete');
        if ($id = input('get.id')) {
            $ret = myModel::destroy($id);
            if ($ret) {
               return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
}