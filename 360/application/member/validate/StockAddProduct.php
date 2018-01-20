<?php

namespace app\member\validate;
use think\Validate;

class StockAddProduct extends Validate
{
    protected $rule = [
        'pname'       =>  'require',
        'gid'   =>  'require',
        'fid'   =>  'require',
        'selling_price'      =>  'require',
        'sn'      =>  'require',
    ];

    protected $message = [
        'pname'       =>  '产品名称不能为空',
        'gid'   =>  '供应商不能为空',
        'fid'   =>  '产品分类不能为空',
        'selling_price'      =>  '销售价不能为空',
        'sn'      =>  '产品编码不能为空',
    ];
}