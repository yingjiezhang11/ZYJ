<?php
namespace app\member\model;
use app\common\model\BaseModel;

class StockProduct extends BaseModel
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
        //$arr = self::where("status <> '3'")->column('name', 'id');
        $rst = self::Distinct(true)->group('fid')->where("status <> '3'")->order('fid asc')->select();
        $html = '';
        $hasQuit = false;
        foreach ($rst as $row) {
            $rsts = self::where('fid',$row->fid)->order('listorder desc,id asc')->select();
            //查询分类
            $type= \app\member\model\StockSet::where('id',$row['fid'])->find();
            $html .= "<option value=\"{$type->id}\" disabled> ".($type->cname)."</option>";
            foreach ($rsts as $rows) {
                $html .= "<option value=\"{$rows->id}\"> ﹥ ﹥ {$rows->pname}</option>";
            }
        }
        return $html;
    }
    //进行分类处理
    public function peer($data){
        return \cate::peer($data);
    }
    
}