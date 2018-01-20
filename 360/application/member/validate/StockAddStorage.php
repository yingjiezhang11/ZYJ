<?php

namespace app\member\validate;
use think\Validate;

class StockAddStorage extends Validate
{
    protected $rule = [
        'orderid'       =>  'require',

    ];

    protected $message = [
        'orderid'       =>  '订单编号不能为空',
    ];
}