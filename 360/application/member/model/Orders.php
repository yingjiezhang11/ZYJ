<?php

namespace app\member\model;


use app\common\model\BaseModel;

class Orders extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'billtime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('shop_id', SHOP_ID);
    }


}