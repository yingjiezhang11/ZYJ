<?php

namespace app\member\model;

use app\common\model\BaseModel;

class Member extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'lasttime' => 'timestamp',
    ];
//    protected $auto = ['password'];

    protected function base($query)
    {
        //$query->where('member.shop_id', SHOP_ID);
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
        $arr = self::where('shop_id',SHOP_ID)->column('realname', 'uid');
        return \my::option($arr);
    }

    static public $allName = [];

    // 根据ID返回姓名
    static public function id2name($uid) {
        if (empty($uid)) return '';

        if (empty(self::$allName)) {
            self::$allName = self::column('realname','uid');
        }

        return self::$allName[$uid];
    }

    // 返回登录用户的信息
    static function login($field='id') {
        $member = session('member');
        if ($field) {
            return $member[$field];
        }else{
            return $member;
        }
    }

    static $myAuth = [];
    // 判断当前用户是否拥有某权限
    static function authCheck($auth, $showError=false) {
      
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
    //栏目页掉用
    static function option_pids() {
        //筛选出一级栏目
        $rst = self::where('pid','0')->order('uid asc')->select();
        $html = '';
        $hasQuit = false;
        foreach ($rst as $row) {
            if($uid==$row->uid){
                $html .= "<option value=\"{$row->uid}\" selected>{$row['realname']}</option>";
            }else{
                $html .= "<option value=\"{$row->uid}\">{$row->realname}</option>";
            }
        }
        return $html;
        //return \my::option_article($rst);
    }
}