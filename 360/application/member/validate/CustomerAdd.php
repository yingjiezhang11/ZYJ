<?php

namespace app\member\validate;
use think\Validate;

class CustomerAdd extends Validate
{
    protected $rule = [
        'company'       =>  'require',
        'mobile'   =>  'require',
        'status'   =>  'require',
        'province'      =>  'require',
        'city'      =>  'require',
        'address'      =>  'require',
        'sales'      =>  'require',
        'service'      =>  'require',
    ];

    protected $message = [
        'company'       =>  '客户名称不能为空',
        'mobile'   =>  '客户手机不能为空',
        'status'   =>  '客户状态不能为空',
        'province'      =>  '客户省份不能为空',
        'city'      =>  '客户城市不能为空',
        'address'      =>  '客户地址不能为空',
        'sales'      =>  '业务员不能为空',
        'service'      =>  '客服人员不能为空',
    ];
}