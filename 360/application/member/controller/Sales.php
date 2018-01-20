<?php
namespace app\member\controller;
use app\common\controller\MemberBase;
use app\member\model\Orders;
use app\member\model\OrdersData;
use app\member\model\Customer;
use app\member\model\Member;
use app\member\model\StockProduct;
class Sales extends MemberBase
{
    //客户列表
    function index(){
        \my::m_auth('customer-list');//权限管理
        $list = Orders::where($where)->order('addtime desc')->paginate();
        return view('index',[
            'list'=>$list,
        ]);
    }
    //添加订单
    function add(){
        \my::m_auth('customer-list-auth-add');//权限管理
        if (request()->isPost()) {
            $data = input('post.');
            $data['shop_id'] = SHOP_ID;
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            $data['billtime'] =  strtotime(input('post.billtime'));
            $data['status'] = '1';
            \my::valid('OrdersAdd', $data);
            $data['unpaid'] = $data['total_money'] - $data['received'];
            if($data['received'] > $data['total_money']){
                \my::error('已收款金额不能大于总金额');
            }
            Orders::insert($data);
            $orderid=Orders::getLastInsID();
            //获取订单详情
            $pid = $_POST['data_pid'];
            $quantity = $_POST['data_quantity'];
            $price = $_POST['data_price'];
            $discount_rate = $_POST['data_discount_rate'];
            $discount_money = $_POST['data_discount_money'];
            $money = $_POST['data_money'];
            $remark = $_POST['data_remark'];
            
            foreach ($pid as $i=>$r){
                $data['shop_id'] = SHOP_ID;
                $data['orderid'] = $orderid;
                $data['pid'] = $pid[$i];
                $data['quantity'] = $quantity[$i];
                $data['price'] = $price[$i];
                $data['discount_rate'] = $discount_rate[$i];
                $data['discount_money'] = $discount_money[$i];
                $data['money'] = $money[$i];
                $data['remark'] = $remark[$i];
                //采购入库
                if($data['pid']){
                    OrdersData::insert($data);
                }
            }
            return $this->success('操作成功');
        }
        return view('add');
    }
    
    //修改订单
    function edit(){
        \my::m_auth('customer-list-auth-add');//权限管理
        $id=input('get.id');
        if(!$id){\my::error('缺少参数：id');}
        if (request()->isPost()) {
            $data = input('post.');
            $data['shop_id'] = SHOP_ID;
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            $data['billtime'] =  strtotime(input('post.billtime'));
            $data['status'] = '1';
            \my::valid('OrdersAdd', $data);
            $data['unpaid'] = $data['total_money'] - $data['received'];
            if($data['received'] > $data['total_money']){
                \my::error('已收款金额不能大于总金额');
            }
            Orders::where('id',$id)->update($data);
            //获取订单详情
            $oid = $_POST['data_id'];
            $pid = $_POST['data_pid'];
            $quantity = $_POST['data_quantity'];
            $price = $_POST['data_price'];
            $discount_rate = $_POST['data_discount_rate'];
            $discount_money = $_POST['data_discount_money'];
            $money = $_POST['data_money'];
            $remark = $_POST['data_remark'];
            
            foreach ($pid as $i=>$r){
                $data['shop_id'] = SHOP_ID;
                $data['orderid'] = $id;
                $data['id'] = $oid[$i];
                $data['pid'] = $pid[$i];
                $data['quantity'] = $quantity[$i];
                $data['price'] = $price[$i];
                $data['discount_rate'] = $discount_rate[$i];
                $data['discount_money'] = $discount_money[$i];
                $data['money'] = $money[$i];
                $data['remark'] = $remark[$i];
                //查询是否入库过
                if($data['id']){
                    $orderdatas=OrdersData::get($data['id']);
                    OrdersData::where('id',$data['id'])->update($data);
                }elseif($data['pid']){
                    OrdersData::insert($data);
                }
            }
            return $this->success('操作成功');
        }else{
            $where="id = ".$id;
            $list = Orders::where($where)->order('id asc')->find();
            $listdata = OrdersData::where('orderid',$id)->order('id asc')->select();
        }
        return view('edit',[
            'list'=>$list,
            'listdata'=>$listdata,
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
            'list'=>$list,
        ]);
    }
    
    //退单
    public function delete_ordersdata(){
        $id = input('id/d') ?: \my::error('缺少参数：id');
        $pro = OrdersData::get($id);
        if (empty($pro)){
            \my::error('没有该数据');
        }else{
            OrdersData::where('id',$id)->delete();
            \my::error('删除成功');
        }
        return json($pro);
    }
    
    //开单-获取产品信息
    public function get_product(){
        $id = input('id/d') ?: \my::error('缺少参数：id');
        $pro = StockProduct::get($id);
        if (empty($pro)){
            \my::error('没有该数据');
        }
        return json($pro);
    }
    //退回订单
    function returnorder(){
        \my::m_auth('customer-list');//权限管理
        $where="status='3'";
        $list = Orders::where($where)->order('addtime desc')->paginate();
        return view('returnorder',[
            'list'=>$list,
        ]);
    }
    //删除订单
    function delete(){
        //判断权限
        \my::m_auth('customer-list-auth-delete');
        if ($id = input('get.id')) {
            $o= Orders::get($id);
            if($o['status']!='1'){\my::error('订单已经在处理中..禁止删除');}
            $ret = Orders::destroy($id);
            if ($ret) {
                //删除数据
                OrdersData::where('orderid',$id)->delete();
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }


}