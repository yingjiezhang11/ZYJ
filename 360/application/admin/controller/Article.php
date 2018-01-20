<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\admin\model\Column;
use app\admin\model\Article as myModel;

class Article extends Base
{
    //文章列表
    function index() {
        \my::auth('content-article');
        if(input('get.cid')){
            $where="cid =".input('get.cid')." and type='1'";
        }else{
            $where="type='1'";
        }
        $model = new myModel();
        $list = $model->where($where)->order('listorder desc,id desc')->paginate();
        
        return view('index', [
            'list' => $list
        ]);
    }
    //添加文章
    function add() {
        \my::auth('content-article-auth-add');
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime']=time();
            $data['userid']=USER_ID;
            $data['type']='1';//1 文章类型，2 单页类型
            \my::valid('ArticleAdd', $data);
            $model = new myModel();
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $model->insert($data);
            $this->success('保存成功！', url('Article/index'));
        }
        return view('edit');
    }
    //编辑文章
    function edit() {
        \my::auth('content-article-auth-edit');
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime']=time();
            $data['userid']=USER_ID;
            $data['type']='1';//1 文章类型，2 单页类型
            $id = input('post.id');
            \my::valid('ArticleAdd', $data);
            $model = new myModel();
            $model->save($data,['id'=>$id]);
            return $this->success('保存成功！', url('Article/index'));
        }elseif($id = input('get.id')) {
            $role = myModel::get($id) ?: abort(404);
            $role['content'] = htmlspecialchars_decode($role['content']);
            $role['content_en'] = htmlspecialchars_decode($role['content_en']);
        }
        return $this->fetch('edit', [
            'editData' => $role,
        ]);
    }
    //删除文章
    function delete() {
        \my::auth('content-article-auth-delete');
        if ($id = input('get.id')) {
            $ret = myModel::destroy($id);
            if ($ret) {
               return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
}