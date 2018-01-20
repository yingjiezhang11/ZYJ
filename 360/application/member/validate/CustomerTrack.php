<?php

namespace app\member\validate;
use think\Validate;

class CustomerTrack extends Validate
{
    protected $rule = [
        'linkman'       =>  'require',
        'type'   =>  'require',
        'remark'   =>  'require',
    ];

    protected $message = [
        'linkman'       =>  '联系人不能为空',
        'type'   =>  '跟踪方式不能为空',
        'remark'   =>  '跟踪内容不能为空',
    ];
}