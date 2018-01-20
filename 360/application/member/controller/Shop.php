<?php

namespace app\member\controller;
use app\common\controller\MemberBase;
use app\member\model\Shop as myModel;
use app\member\model\Member;

class Shop extends MemberBase
{
    //客户列表
    function index(){
        \my::m_auth('shop-list');//权限管理
        //搜索
        $list= myModel::get(SHOP_ID);
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            //\my::valid('CustomerAdd', $data);
            //判断手机号码
            if($list){
                myModel::where('shop_id',SHOP_ID)->update($data);
            }else{
                myModel::insert($data);
                $shop_id=myModel::getLastInsID();
                //更新用户数据库
                Member::where('uid',U_ID)->update('shop_id',$shop_id);
                define('SHOP_ID', $shop_id);
            }
            return $this->success('操作成功');
        }else{
            
        }
        return view('index',[
            'editData'=>$list,
        ]);
    }

    
}