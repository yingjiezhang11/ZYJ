<?php

namespace app\member\model;


use app\common\model\BaseModel;

class Customer extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'updatetime' => 'timestamp',
        'retime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('customer.shop_id', SHOP_ID);
    }

    static function option() {
        $arr = self::column('company', 'id');
        return \my::option($arr);
    }
}