<?php

namespace app\member\model;


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
        $query->where('role.delete_time', 'null');
    }

    static function option() {
        $arr = self::column('name', 'id');
        return \my::option($arr);
    }
}