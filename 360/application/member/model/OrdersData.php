<?php

namespace app\member\model;


use app\common\model\BaseModel;

class OrdersData extends BaseModel
{
    protected $type = [
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('shop_id', SHOP_ID);
    }

}