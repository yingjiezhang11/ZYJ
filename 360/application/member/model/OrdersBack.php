<?php

namespace app\member\model;


use app\common\model\BaseModel;

class OrdersBack extends BaseModel
{
    protected $type = [
        'datetime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('shop_id', SHOP_ID);
    }

}