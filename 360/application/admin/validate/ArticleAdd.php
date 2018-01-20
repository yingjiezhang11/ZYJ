<?php

namespace app\admin\validate;


use think\Validate;
use app\admin\model\User as myModel;

class ArticleAdd extends Validate
{
    protected $rule = [
        'title'       =>  'require',
        'templates'   =>  'require',
        'status'      =>  'require',
        'content'      =>  'require'
    ];

    protected $message = [
        'title'       =>  '请输入标题',
        'templates'   =>  '请输入文章模板，默认 show',
        'status'      =>  '请选择文章状态',
        'content'      =>  '请输入网站内容'
    ];
}