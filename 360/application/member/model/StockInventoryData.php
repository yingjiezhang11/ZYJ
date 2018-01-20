<?php
namespace app\member\model;
use app\common\model\BaseModel;

class StockInventoryData extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'updatetime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        $query->where('shop_id',SHOP_ID);
    }
    //option
    static function option() {
        $arr = self::where("status <> '3'")->column('name', 'id');
        return \my::option($arr);
    }
    //进行分类处理
    public function peer($data){
        return \cate::peer($data);
    }
    
}