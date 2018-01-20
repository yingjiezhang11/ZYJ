<?php

namespace app\member\controller;
use app\common\controller\MemberBase;
use app\member\model\Customer as myModel;
use app\member\model\CustomerTrack;
use app\member\model\Member;
class Customer extends MemberBase
{
    //客户列表
    function index(){
        \my::m_auth('customer-list');//权限管理
        //搜索
        $model = new myModel;
        if ($company = input('company')) {
            $model->where("company","like",'%'.$company.'%');
        }
        if ($mobile = input('mobile')) {
            $model->where("mobile","=",$mobile);
        }
        if ($province = input('province')) {
            $model->where("province","=",$province);
        }
        if ($city = input('city')) {
            $model->where("city","=",$city);
        }
        if ($type = input('type')) {
            $model->where("type","=",$type);
        }
        if ($status = input('status')) {
            $model->where("status","=",$status);
        }
        if ($sales = input('sales')) {
            $model->where("sales","=",$sales);
        }
        if ($service = input('service')) {
            $model->where("service","=",$service);
        }
        if ($sort = input('sort')) {
            $sort = input('sort') ?: 'desc';
        }
        
        //获取用户信息
        $member=Member::where('uid',U_ID)->find();
        //权限判断
        $isAuth = Member::authCheck('customer-list-auth-all');
        if(!$isAuth){
            $model->where("userid ='".U_ID."' or sales ='".U_ID."' or service ='".U_ID."'");
        }
        $list = $model->where($where)->order('addtime desc')->paginate();
        return view('index',[
            'list'=>$list,
        ]);
    }
    //客户列表
    function search(){
        \my::m_auth('customer-search');//权限管理
        
        return view('search');
    }
    //添加客户
    function add(){
        \my::m_auth('customer-list-auth-add');//权限管理
        $model = new myModel;
        if (request()->isPost()) {
            $data = input('post.');
            $data['shop_id'] = SHOP_ID;
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            if($data['retime']){
                $data['retime'] =  strtotime(input('post.retime')) ;
            }else{
                $data['retime'] =  time()+432000 ;
            }
            \my::valid('CustomerAdd', $data);
            //验证手机号码
            if(!preg_match("/^1[0-9]{10}$/",$data['mobile'])){\my::error('手机号码格式不对');}
            //判断手机号码
            $mob=$model->where([
                'mobile'=>$data['mobile'],
                'shop_id'=>SHOP_ID,
            ])->find();
            if($mob){
                $us=Member::where('uid',$mob['userid'])->find();
                \my::error('该手机已被 '.$us['realname'].' 登记到系统');
            }
            $model->insert($data);
            return $this->success('操作成功');
        }
        return $this->fetch('edit');
    }
    //修改客户
    function edit(){
        \my::m_auth('customer-list-auth-edit');//权限管理
        $model = new myModel;
        $id = input('get.id');
        $list=$model->where('id',$id)->find();
        if (request()->isPost()) {
            $data = input('post.');
            $data['updatetime'] = time();
            $data['retime'] =  strtotime(input('post.retime')) ;
            // \my::valid('CustomerAdd', $data);
            //验证手机号码
            if(!preg_match("/^1[0-9]{10}$/",$data['mobile'])){\my::error('手机号码格式不对');}
            //判断手机号码
            if($data['mobile']!=$list['mobile']){
                $mob=$model->where([
                    'mobile'=>$data['mobile'],
                    'shop_id'=>SHOP_ID,
                ])->find();
                if($mob){\my::error('手机号码已存在!');}
            }
            $model->where('id',$id)->update($data);
            return $this->success('操作成功');
        }else{
            
        }
        return $this->fetch('edit', [
            'editData' => $list,
        ]);
    }
    //删除客户
    function delete(){
        //判断权限
        \my::m_auth('customer-list-auth-delete');
        $model = new myModel;
        if ($id = input('get.id')) {
            $ret = $model->destroy($id);
            if ($ret) {
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    //跟踪记录
    function track(){
        \my::m_auth('customer-track');//权限管理
        $id=input('get.id');
        //获取用户信息
        $member=Member::where('uid',U_ID)->find();
        if($id){
            $where="cid = '".$id."'";
            //$model->where('cid',$id);
        }else{
            //权限判断
            $isAuth = Member::authCheck('customer-list-auth-all');
            if(!$isAuth){
                $where="userid = '".U_ID."'";
                //$model->where("userid ='".U_ID."'");
            }
        }
        $cus= myModel::where('id',$id)->find();
        $list = CustomerTrack::where($where)->order('addtime desc')->paginate();
        return view('track',[
            'list'=>$list,
            'customer'=>$cus,
        ]);
    }
    //添加跟踪记录
    function track_add(){
        \my::m_auth('customer-track-auth-add');//权限管理
        $id=input('get.id');
        if (request()->isPost()) {
            $data = input('post.');
            $data['shop_id'] = SHOP_ID;
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            $data['cid'] = $id;
            \my::valid('CustomerTrack', $data);
            CustomerTrack::insert($data);
            //设定下次回访时间
            if($data['retime']){
                myModel::where('id',$id)->update('retime',strtotime($data['retime']));
            }
            //微信提醒
            $customer=myModel::where('id',$id)->find();//查询客户信息
            $sales= Member::where('uid',$customer['sales'])->find();//查询业务员
            $user= Member::where('uid',U_ID)->find();//查询添加人
            $service= Member::where('uid',$customer['service'])->find();//查询客服
            if($sales['openid'] and U_ID!=$sales['uid']){
                \app\weixin\model\Message::tixing($sales['openid'],$customer['company'],$user['realname'],\my::selectText('track_type',$data['type']),$data['remark'],"http://erp.ennn.cn/member/customer/track?id=".$id);
            }
            if($service['openid'] and U_ID!=$service['uid']){
                \app\weixin\model\Message::tixing($service['openid'],$customer['company'],$user['realname'],\my::selectText('track_type',$data['type']),$data['remark'],"http://erp.ennn.cn/member/customer/track?id=".$id);
            }
            
            return $this->success('操作成功');
        }
        return $this->fetch('track_edit');
    }
    //修改跟踪记录
    function track_edit(){
        \my::m_auth('customer-track-auth-edit');//权限管理
        $id = input('get.id');
        $list=CustomerTrack::where('id',$id)->find();
        if (request()->isPost()) {
            $data = input('post.');
            \my::valid('CustomerTrack', $data);
            CustomerTrack::where('id',$id)->update($data);
            //设定下次回访时间
            if($data['retime']){
                myModel::where('id',$list['cid'])->update(['retime'=>strtotime($data['retime'])]);
            }
            return $this->success('操作成功');
        }else{
            
        }
        return $this->fetch('track_edit', [
            'editData' => $list,
        ]);
    }
    //删除跟踪记录
    function track_delete(){
        //判断权限
        \my::m_auth('customer-track-auth-delete');
        if ($id = input('get.id')) {
            $ret = CustomerTrack::destroy($id);
            if ($ret) {
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    //回访提醒
    function visit(){
        \my::m_auth('customer-track');//权限管理
        //获取用户信息
        $member=Member::where('uid',U_ID)->find();
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        
        //权限判断
        $isAuth = Member::authCheck('customer-list-auth-all');
        if(!$isAuth){
            myModel::where("userid = '".U_ID."' and retime <= '".$endToday."' and retime <> '0'");
        }else{
            myModel::where("retime <= '".$endToday."' and retime <> '0'");
        }
        $list = myModel::where($where)->order('retime desc')->paginate();
        return view('index',[
            'list'=>$list,
        ]);
    }
    
    
}