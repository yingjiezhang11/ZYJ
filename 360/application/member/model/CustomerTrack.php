<?php

namespace app\member\model;


use app\common\model\BaseModel;

class CustomerTrack extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('shop_id', SHOP_ID);
    }

    static function option() {
        $arr = self::column('name', 'id');
        return \my::option($arr);
    }
}