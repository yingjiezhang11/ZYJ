<?php
namespace app\weixin\controller;

use app\common\controller\MemberBase;
use app\weixin\model\WxUser;
use think\Db;
class Index extends MemberBase
{
    //个人中心首页
    function index() {
        //判断权限
        $user= WxUser::get_userinfo(OPEN_ID);
        $this->redirect("/member/");
        //return view('index', [
         //   'user' => $user,
        //]);
    }
    //个人基本信息
    function info() {
        //判断权限
        $user= WxUser::get_userinfo(OPEN_ID);
        if(request()->isPost()){
            $data = input('post.');
            Db::table('wx_user')->where('openid',OPEN_ID)->update($data);
            return $this->success('保存成功！',url('index/index'),'',3);
        }
        return view('info', [
            'user' => $user,
        ]);
    }
    //我的艺人
    function yiren(){
        $user= WxUser::get_userinfo(OPEN_ID);
        $list=Db::table('xm_yiren')->where('wxid',$user['wxid'])->paginate();
        return view('yiren', [
            'user' => $user,
            'list' => $list,
        ]);
    }
    //艺人添加
    function yiren_add(){
        $user= WxUser::get_userinfo(OPEN_ID);
        if(request()->isPost()){
            $data = input('post.');
            $data['wxid'] = $user['wxid'];
            $data['addtime'] = time();
            $data['status'] = '88';
            Db::table('xm_yiren')->insert($data);
            $this->success('保存成功！');
        }
        return view('yiren_add');
    }
    //艺人编辑
    function yiren_edit(){
        $id=input('get.id');
        $user= WxUser::get_userinfo(OPEN_ID);
        if(request()->isPost()){
            $data = input('post.');
            $data['wxid'] = $user['wxid'];
            $data['addtime'] = time();
            $data['status'] = '88';
            Db::table('xm_yiren')->where('id',$id)->update($data);
            $this->success('保存成功！');
        }else{
            $yiren = Db::table('xm_yiren')->where('id',$id)->find();
        }
        return view('yiren_add',['yiren'=>$yiren]);
    }
    //艺人照片
    function yiren_photo(){
        $id=input('get.yid');
        $user= WxUser::get_userinfo(OPEN_ID);
        if(request()->isPost()){
            $data = input('post.');
            $data['wxid'] = $user['wxid'];
            $data['datetime'] = time();
            $data['yid'] = $id; 
            Db::table('xm_yiren_photo')->insert($data);
            $this->success('保存成功！');
        }else{
            $yiren = Db::table('xm_yiren_photo')->where('yid',$id)->select();
        }
        return view('yiren_photo',['yiren'=>$yiren]);
    }
    //艺人照片删除
    function yiren_photo_delete(){
        $id=input('get.id');
        $user= WxUser::get_userinfo(OPEN_ID);
        if ($id) {
            $file= Db::table('xm_yiren_photo')->where('id',$id)->find();
            $ret = Db::table('xm_yiren_photo')->where('id',$id)->delete();;
            if ($ret) {
                //同时删除文件
                $filename = config('upload.path').substr($file['photo'],9); 
                unlink($filename);
                \my::error('删除成功');
                //$this->success('删除成功', '');
            }
        }
    }
    //我的活动
    function huodong(){
        $user= WxUser::get_userinfo(OPEN_ID);
        $list=Db::table('xm_huodong')->where('wxid',$user['wxid'])->order('etime desc')->paginate();
        return view('huodong', [
            'user' => $user,
            'list' => $list,
        ]);
    }
    //活动添加
    function huodong_add(){
        $user= WxUser::get_userinfo(OPEN_ID);
        if(request()->isPost()){
            $data = input('post.');
            $data['wxid'] = $user['wxid'];
            $data['addtime'] = time();
            $data['status'] = '88';
            $data['stime']=strtotime($data['stime']);
            $data['etime']=strtotime($data['etime']);
            Db::table('xm_huodong')->insert($data);
            return $this->success('保存成功！', url('System/index'));
        }
        return view('huodong_add');
    }
    //活动编辑
    function huodong_edit(){
        $id=input('get.id');
        $user= WxUser::get_userinfo(OPEN_ID);
        if(request()->isPost()){
            $data = input('post.');
            $data['wxid'] = $user['wxid'];
            $data['addtime'] = time();
            $data['status'] = '88';
            $data['stime']=strtotime($data['stime']);
            $data['etime']=strtotime($data['etime']);
            Db::table('xm_huodong')->where('id',$id)->update($data);
            $this->success('保存成功！');
        }else{
            $yiren = Db::table('xm_huodong')->where('id',$id)->find();
        }
        return view('huodong_add',['yiren'=>$yiren]);
    }
    //报名列表
    function baoming_show(){
        $id=input('get.id');
        $user= WxUser::get_userinfo(OPEN_ID);
        $list=Db::table('xm_huodong_baoming')->where('hdid',$id)->paginate();
        return view('huodong_baoming_show', [
            'user' => $user,
            'list' => $list,
        ]);
    }
    //我要报名
    function baoming(){
        $hdid=input('get.hdid');
        $user= WxUser::get_userinfo(OPEN_ID);
        //查询是否报名
        $s= Db::table('xm_huodong_baoming')->where(['hdid'=>$hdid,'wxid'=>$user['wxid']])->find();
        if($s){
           $this->success('您已经报名过了！'); 
        }else{
            //查询是否自己发布的
            $h=Db::table('xm_huodong')->where('id',$hdid)->find();
            if($h){
                $this->success('您不能报名自己发布的活动！');
            }else{
                $h=Db::table('xm_huodong_baoming')->insert(['hdid'=>$hdid,'wxid'=>$user['wxid'],'addtime'=>time(),'status'=>'88']);
                $this->success('报名成功！');
            }
        }

    }
    //退出微信登陆
    function logout() {
        session('weixin', null);
        $this->redirect('index');
    }

 
    
}