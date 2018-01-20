<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class Log extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        //$query->where('system.id', '1');
    }

}