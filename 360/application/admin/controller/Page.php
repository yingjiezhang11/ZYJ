<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\admin\model\Column;
use app\admin\model\Article as myModel;

class Page extends Base
{
    //文章列表
    function index() {
        \my::auth('content-page');
        $model = new myModel();
        $cid = input('get.cid');
        //有CID
        if($cid){
            if (request()->isPost()) {
                $data = input('post.');
                $data['addtime']=time();
                $data['userid']=USER_ID;
                $data['type']='2';//1 文章类型，2 单页类型
                $id = input('post.id');
                //\my::valid('ArticleAdd', $data);
                $model->save($data,['id'=>$id]);
                return $this->success('保存成功！', url('page/index')."?cid=".$cid);
            }else{
                //查询是否已有文章
                $list = $model->where(['cid'=>$cid])->find();
                $list['content'] = htmlspecialchars_decode($list['content']);
                $list['content_en'] = htmlspecialchars_decode($list['content_en']);
                if($list['cid']==''){
                    //没有数据，插入一条
                    $model->insert(['cid'=>$cid,'title'=>'标题','status'=>'99','listorder'=>'0','addtime'=>time(),'userid'=>USER_ID,'type'=>'2']);
                    $list = $model->where('cid',$cid)->find();
                    $list['content'] = htmlspecialchars_decode($list['content']);
                }
            }
        }
        return view('index', [
            'editData' => $list
        ]);
    }
}