<?php

namespace app\admin\controller;

use app\common\controller\Base;
use app\weixin\model\WxUser;
use app\weixin\model\XmYiren;
use app\weixin\model\XmHuodong;
use think\Db;
use think\Request;

class Weixin extends Base
{
    //系统设置
    function index() {
        //判断权限
        \my::auth('weixin-list');
        $list = WxUser::where('')->order('wxid desc')->paginate();
        return view('index', [
            'list' => $list,
        ]);
    }
    //艺人管理
    function yiren() {
        //判断权限
        \my::auth('weixin-yiren');
        $list = XmYiren::where('')->order('id desc')->paginate();
        return view('yiren', [
            'list' => $list,
        ]);
    }
    //艺人管理
    function yiren_edit() {
        //判断权限
        \my::auth('weixin-yiren');
        $id = input('get.id');
        $list = XmYiren::where('id',$id)->find();
        if(request()->isPost()){
            $data = input('post.');
            $data['updatetime'] = time();
            XmYiren::where('id',$id)->update($data);
            //发送模板消息
            if($data['status']=='99'){
              $u= \app\weixin\model\WxUser::where('wxid',$list['wxid'])->find();
              \app\admin\model\Weixin::moban_yiren_shenhe($u['openid'], $data['xingming']);
            }elseif($data['status']=='0'){
              $u= \app\weixin\model\WxUser::where('wxid',$list['wxid'])->find();
              \app\admin\model\Weixin::moban_yiren_jujue($u['openid'], $data['xingming']);
            }
            return $this->success('操作成功');
        }
        return $this->fetch('yiren_edit', [
            'list' => $list,
        ]);
    }
    //艺人删除
    function yiren_delete() {
        \my::auth('weixin-yiren');
        if ($id = input('get.id')) {
            $ret = XmYiren::destroy($id);
            if ($ret) {
               //同时删除相关照片
                Db::table('xm_yiren_photo')->where('yid',$id)->delete();
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    //活动管理
    function huodong() {
        //判断权限
        \my::auth('weixin-yiren');
        $list = XmHuodong::where('')->order('id desc')->paginate();
        return view('huodong', [
            'list' => $list,
        ]);
    }
    //活动管理
    function huodong_edit() {
        //判断权限
        \my::auth('weixin-yiren');
        $id = input('get.id');
        $list = XmHuodong::where('id',$id)->find();
        if(request()->isPost()){
            $data = input('post.');
            $data['stime']=strtotime($data['stime']);
            $data['etime']=strtotime($data['etime']);
            XmHuodong::where('id',$id)->update($data);
            //发送模板消息
            if($data['status']=='99'){
              $u= \app\weixin\model\WxUser::where('wxid',$list['wxid'])->find();
              \app\admin\model\Weixin::moban_huodong_shenhe($u['openid'], $data['title']);
            }elseif($data['status']=='0'){
              $u= \app\weixin\model\WxUser::where('wxid',$list['wxid'])->find();
              \app\admin\model\Weixin::moban_huodong_jujue($u['openid'], $data['title']);
            }
            return $this->success('操作成功');
        }
        return $this->fetch('huodong_edit', [
            'list' => $list,
        ]);
    }
    //活动删除
    function huodong_delete() {
        \my::auth('weixin-yiren');
        if ($id = input('get.id')) {
            $ret = XmHuodong::destroy($id);
            if ($ret) {
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    //活动报名情况
    function huodong_baoming() {
        //判断权限
        \my::auth('weixin-yiren');
        $id = input('get.id');
        $list = Db::table('xm_huodong_baoming')->where('hdid',$id)->order('id desc')->paginate();
        return view('huodong_baoming', [
            'list' => $list,
        ]);
    }

    
}