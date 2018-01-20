<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\admin\model\Role as myModel;

class Role extends Base
{
    function index() {
        \my::auth('user-role');
        $model = new myModel();
        $list = $model->order('type desc')->paginate();
        return view('index', [
            'list' => $list
        ]);
    }

    function edit() {
        \my::auth('user-role-auth-edit');
        if (request()->isPost()) {
            $data = input('post.');

            if (!$data['auth']) {
                $data['auth'] = [];
            }

            if ($id = input('get.id')) {
                $role = myModel::get($id) ?: abort(404);
            }else{
                $role = new myModel();
            }
            $role->save($data);

            return $this->success('保存成功！', url('Role/index'));
        }elseif($id = input('get.id')) {
            $role = myModel::get($id) ?: abort(404);
        }
        return view('edit', [
            'editData' => $role,
        ]);
    }

    function delete() {
        \my::auth('user-role-auth-delete');
        if ($id = input('get.id')) {
            $ret = myModel::destroy($id);
            if ($ret) {
                $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
}