<?php

namespace app\member\controller;
use app\common\controller\MemberBase;
use app\member\model\Shop as myModel;
use app\member\model\Member;
use app\member\model\Orders;
use app\member\model\OrdersData;
use app\member\model\StockSet;
use app\member\model\StockProduct;
use app\member\model\StockStorage;
use app\member\model\StockInventory;
use app\member\model\StockInventoryData;
use think\Request;
use think\Db;
class Stock extends MemberBase
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
    //库存盘点
    function inventory(){
        \my::m_auth('stock-inventory');//权限管理
        //搜索
        $list= StockInventory::where($where)->order('addtime desc')->paginate();;
        return view('inventory',[
            'list'=>$list,
        ]);
    }
    //盘点录入
    function add_inventory(){
        \my::m_auth('stock-inventory');//权限管理
        if (request()->isPost()) {
            $data = input('post.');
            if($data['addtime']==''){
                \my::error('盘点日期不能为空');
            }
            $data['addtime'] = strtotime(input('post.addtime'));
            $data['userid'] = U_ID;
            $data['shop_id'] = SHOP_ID;
            StockInventory::insert($data);
            return $this->success('操作成功',url('inventory'));
        }
        return $this->fetch('add_inventory');
    }
    //库存盘点
    function show_inventory(){
        \my::m_auth('stock-inventory');//权限管理
        //搜索
        $id=input('get.id');
        if(!$id) {
            \my::error('参数错误');
        }
        $where="status <>'3'";
        $list= StockProduct::where($where)->order('gid asc,fid asc,id desc')->paginate();
        if (request()->isPost()) {
            $data = input('post.');
            $data['iid'] = $id;
            $data['shop_id'] = SHOP_ID;
            $data['addtime'] = time();
            StockInventoryData::insert($data);
            return $this->success('操作成功');
        }
        return view('show_inventory',[
            'list'=>$list,
        ]);
    }
    //采购入库
    function storage(){
        \my::m_auth('stock-product');//权限管理
        //搜索
        $list= StockStorage::Distinct(true)->group('orderid')->where($where)->order('addtime desc')->paginate();;
        return view('storage',[
            'list'=>$list,
        ]);
    }
    //采购入库
    function add_storage(){
        \my::m_auth('stock-product');//权限管理
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            $data['shop_id'] = SHOP_ID;
            \my::valid('StockAddStorage', $data);
            //验证产品编码
            $p=StockStorage::where('orderid',$data['orderid'])->find();
            if($p){
                \my::error('订单编号已经存在');
            }
            $pid = $_POST['pid'];
            $buying_price = $_POST['buying_price'];
            $amount = $_POST['amount'];
            foreach ($pid as $i=>$r){
                $data['pid'] = $r;
                $data['buying_price'] = $buying_price[$i];
                $data['amount'] = $amount[$i];
                //采购入库
                StockStorage::insert($data);
                //更新产品数量
                $p=StockProduct::where('id',$r)->setInc('amount',$data['amount']);
            }
            return $this->success('操作成功',url('storage'));
        }else{
            //供应商列表
            
        }
        return $this->fetch('add_storage');
    }
    //采购清单
    function show_storage(){
        \my::m_auth('stock-product');//权限管理
        //搜索
        $orderid=input('get.orderid');
        $list= StockStorage::where('orderid',$orderid)->select();;
        return $this->fetch('show_storage',[
            'list'=>$list,
        ]);
    }
    //产品设置
    function product(){
        \my::m_auth('stock-product');//权限管理
        //搜索
        $list= StockProduct::where($where)->order('addtime desc')->paginate();;
        
        return view('product',[
            'list'=>$list,
        ]);
    }
    //添加产品
    function add_product(){
        \my::m_auth('stock-product');//权限管理
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            $data['amount'] = '0';//默认为 0
            $data['shop_id'] = SHOP_ID;
            \my::valid('StockAddProduct', $data);
            //验证产品编码
            $p=StockProduct::where('sn',$data['sn'])->find();
            if($p){
                \my::error('产品编码已经存在');
            }
            StockProduct::insert($data);
            return $this->success('操作成功');
        }else{
            //供应商列表
            
        }
        return $this->fetch('add_product');
    }
    //修改产品
    function edit_product(){
        \my::m_auth('stock-product');//权限管理
        $id=input('get.id');
        if (request()->isPost()) {
            $data = input('post.');
            $data['updatetime'] = time();
            \my::valid('StockAddProduct', $data);
            //验证产品编码
            $p=StockProduct::where("sn='".$data[sn]."' and id<>'".$id."'")->find();
            if($p){
                \my::error('产品编码已经存在');
            }
            StockProduct::where('id',$id)->update($data);
            return $this->success('操作成功');
        }else{
            //供应商列表
            $list=StockProduct::where('id',$id)->find();
        }
        return $this->fetch('add_product',[
            'list'=>$list,
        ]);
    }
    //删除设置
    function delete_product(){
        \my::m_auth('stock-setting');
        if ($id = input('get.id')) {
            $ret = StockProduct::destroy($id);
            if ($ret) {
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    //库存设置
    function setting(){
        \my::m_auth('stock-setting');//权限管理
        //搜索
        //$list= myModel::get(SHOP_ID);
        $gys=StockSet::where('type','1')->order('id desc')->select();
        $fenlei=StockSet::where(['type'=>'2','pid'=>'0'])->order('listorder desc,id desc')->select();
        //$fenlei = StockSet::where('type','2')->order('listorder desc,id asc')->column('name,pid,type,listorder','id');
        //$fenlei = StockSet::peer($fenlei);
        return view('setting',[

            'gys'=>$gys,
            'fenlei'=>$fenlei,
        ]);
    }
    //添加设置
    function add_set(){
        \my::m_auth('stock-setting');//权限管理
        //搜索
        $type=input('get.type');
        if(!$type){ return \my::error('添加参数错误');}
        if (request()->isPost()) {
            $data = input('post.');
            $data['addtime'] = time();
            $data['userid'] = U_ID;
            $data['shop_id'] = SHOP_ID;
            StockSet::insert($data);
            return $this->success('操作成功');
        }else{
            //供应商列表
            
        }
        return $this->fetch('add_set',[
            'list'=>$list,
            'type'=>$type,
            
        ]);
    }
    //修改设置
    function edit_set(){
        \my::m_auth('stock-setting');//权限管理
        //搜索
        $id=input('get.id');
        if (request()->isPost()) {
            $data = input('post.');
            StockSet::where('id',$id)->update($data);
            return $this->success('操作成功');
        }else{
            //供应商列表
            $list= StockSet::get($id);
            $type=$list['type'];
        }
        return $this->fetch('add_set',[
            'list'=>$list,
            'type'=>$type,  
        ]);
    }
    //删除设置
    function delete_set(){
        \my::m_auth('stock-setting');
        if ($id = input('get.id')) {
            $ret = StockSet::destroy($id);
            if ($ret) {
                return $this->success('操作成功', '');
            }
        }
        \my::error('未知错误');
    }
    //订单管理
    function orders(){
        \my::m_auth('customer-list');//权限管理
        $where="status='2'";
        $list = Orders::where($where)->order('addtime desc')->paginate();
        return view('orders',[
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
            'list'=>$list,
        ]);
    }

    
}