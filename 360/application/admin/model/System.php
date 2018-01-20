<?php

namespace app\admin\model;


use app\common\model\BaseModel;

class System extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'updatetime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('system.id', '1');
    }

    static function option() {
        $arr = self::column('name', 'id');
        return \my::option($arr);
    }
}