<?php

namespace app\admin\validate;


use think\Validate;
use app\admin\model\User as myModel;

class Column extends Validate
{
    protected $rule = [
        'cname'       =>  'require',
        'type'   =>  'require',
        'module'      =>  'require'
    ];

    protected $message = [
        'cname'   =>  '栏目名称不能为空',
        'type'      =>  '栏目类型不能为空',
        'module'      =>  '栏目模型不能为空'
    ];
}