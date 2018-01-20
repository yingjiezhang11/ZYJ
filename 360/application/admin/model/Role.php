<?php

namespace app\admin\model;


use app\common\model\BaseModel;

class Role extends BaseModel
{
    protected $type = [
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('role.shop_id',SHOP_ID);
    }

    static function option() {
        $arr = self::where('type','0')->column('name', 'id');
        return \my::option($arr);
    }
    static function option_member() {
        $arr = self::where('type','1')->column('name', 'id');
        return \my::option($arr);
    }
}