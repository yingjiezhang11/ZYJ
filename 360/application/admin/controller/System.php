<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\admin\model\System as myModel;
use app\admin\model\Upload;
use app\admin\model\User;
use app\admin\model\Log;
use think\Db;
use think\Request;

class System extends Base
{
    //系统设置
    function index() {
        //判断权限
        \my::auth('system-list');
        $list = new myModel();
        $id = input('get.id')?:'1';
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime'] = time();
            $data['updatetime'] = time();
            $list->save($data,['id'=>$id]);
            return $this->success('保存成功！', url('System/index'));
        //默认读取基本配置
        }elseif($id = input('get.id')?:'1') {
            $list = myModel::get($id) ?: abort(404);
        }
        return view('system', [
            'list' => $list,
        ]);
    }
    //附件列表
    function attachment() {
        //判断权限
        \my::auth('system-attachment');
        
        $list = Upload::where('')->order('id desc')->paginate();
        return view('attachment', [
            'list' => $list,
        ]);
    }
    //删除附件
    function delete(){
        //判断权限
        \my::auth('system-attachment-auth-delete');
        if ($id = input('get.id')) {
            $file= \app\admin\model\Upload::get($id);
            $ret = \app\admin\model\Upload::destroy($id);
            if ($ret) {
                //同时删除文件
                $filename = config('upload.path').$file['filename']; 
                unlink($filename);
                \my::error('删除成功', url('System/attachment'));
                //$this->success('删除成功', '');
            }
        }
        \my::error('未知错误');
    }
    //日志列表
    function log() {
        //判断权限
        \my::auth('system-log');
        
        $list = Log::where('')->order('id desc')->paginate();
        return view('log', [
            'list' => $list,
        ]);
    }
    
}