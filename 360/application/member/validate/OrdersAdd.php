<?php

namespace app\member\validate;


use think\Validate;
use app\member\model\Member as myModel;

class OrdersAdd extends Validate
{
    protected $rule = [
        'cid'       =>  'require',
        'order_sn'   =>  'require',
        'sales'   =>  'require',
        'received'      =>  'require',
        'billtime'      =>  'require',
    ];

    protected $message = [
        'cid'       =>  '客户不能为空',
        'order_sn'   =>  '订单编号不能为空',
        'sales'   =>  '业务员不能为空',
        'received'      =>  '已付款金额不能为空',
        'billtime'      =>  '订单日期不能为空',
    ];

}