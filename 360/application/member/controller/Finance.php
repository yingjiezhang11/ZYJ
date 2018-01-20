<?php
namespace app\member\controller;
use app\common\controller\MemberBase;
use app\member\model\Orders;
use app\member\model\OrdersData;
use app\member\model\OrdersBack;
use app\member\model\Customer;
use app\member\model\Member;
use app\member\model\StockProduct;
class Finance extends MemberBase
{
    //客户列表
    function audit(){
        \my::m_auth('customer-list');//权限管理
        $where = "status ='1'";//状态为1的
        $list = Orders::where($where)->order('addtime asc')->paginate();
        return view('audit',[
            'list'=>$list,
        ]);
    }
    //订单详情
    function show(){
        \my::m_auth('customer-list');//权限管理
        $orderid=input('get.id');
        if(!$orderid){\my::error('缺少参数：orderid');}
        $where="orderid = ".$orderid;
        $list = OrdersData::where($where)->order('id asc')->select();
        return $this->fetch('show',[
            'list' => $list,
            'orderid' => $orderid,
        ]);
    }
    //审核通过
    function audited(){
        \my::m_auth('customer-list');//权限管理
        $id=input('get.id');
        if(!$id){\my::error('缺少参数：orderid');}
        $where="id = ".$id;
        $list = Orders::where($where)->update(['status'=>'2']);//审核通过
        $this->success('审核成功');
    }
    //退回订单
    function return_order(){
        \my::m_auth('customer-list');//权限管理
        $id=input('get.id');
        if(!$id){\my::error('缺少参数：orderid');}
        if (request()->isPost()) {
            $data = input('post.');
            $data['shop_id'] = SHOP_ID;
            $data['orderid'] = $id;
            $data['userid'] = U_ID;
            $data['datetime'] = time();
            //添加退单内容
            OrdersBack::insert($data);
            //修改订单状态
            Orders::where(['id'=>$id])->update(['status'=>'3']);//退单
            $this->success('退单成功');
        }
        return $this->fetch('return_order');
    }


}