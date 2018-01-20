<?php

namespace app\admin\validate;


use think\Validate;
use app\admin\model\User as myModel;

class User extends Validate
{
    protected $rule = [
        'username|用户名'  =>  'require|myUsername',
        'password|密码' => 'require',
        'role_id|权限角色'  =>  'require',
//        'realname|姓名' => 'require',
//        'title|岗位' => 'require',
    ];
    protected $scene = [
        // 修改时不验证密码
        'edit'  =>  ['username', 'role_id'],
    ];

    protected function myUsername($value,$rule,$data)
    {
        // 必须全局唯一，不然登录的时候不知道哪个店。
        $model = myModel::useGlobalScope(false)->where('username', $value);
        if ($data['id']) {
            $model->where('id', '<>', $data['id']);
        }
        return $model->count() ? '用户名已存在' : true;
    }
}