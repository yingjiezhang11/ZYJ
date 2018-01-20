<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class User extends BaseModel
{
    protected $type = [
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];
//    protected $auto = ['password'];

    protected function base($query)
    {
        $query->where('user.delete_time', 'null');
    }


    static function passwordEncode($pwd) {
        return md5('http://www.sucaihuo.com/'.$pwd);
    }

    function setPasswordAttr($value) {
        if ($value) {
            return self::passwordEncode($value);
        }else{
            // 为空不更新
            return $this['password'];
        }
    }


    public function Role()
    {
        return $this->belongsTo('Role');
    }


    static function option() {
        $arr = self::column('realname', 'id');
        return \my::option($arr);
    }

    static public $allName = [];

    // 根据ID返回姓名
    static public function id2name($id) {
        if (empty($id)) return '';

        if (empty(self::$allName)) {
            self::$allName = self::column('realname','id');
        }

        return self::$allName[$id];
    }

    // 返回登录用户的信息
    static function login($field='id') {
        $user = session('user');
        if ($field) {
            return $user[$field];
        }else{
            return $user;
        }
    }

    static $myAuth = [];
    // 判断当前用户是否拥有某权限
    static function authCheck($auth, $showError=false) {
        if (IS_ADMIN) {
            return true;
        }

        if (!self::$myAuth) {
            $rid = self::login('role_id');
            self::$myAuth = Role::get($rid)->auth;
        }

        if (in_array($auth, self::$myAuth)) {
            return true;
        }elseif ($showError) {
            \my::error('您没有访问当前页面的权限');
        }else{
            return false;
        }
    }

}