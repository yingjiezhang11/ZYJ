<?php
namespace app\member\model;
use app\common\model\BaseModel;

class StockSet extends BaseModel
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
    //进行分类处理
    public function peer($data){
        return \cate::peer($data);
    }
    static function option() {
        $arr = self::where(['type'=>'2','pid'=>'0'])->column('cname', 'id');
        return \my::option($arr);
    }
    //供应商调用
    static function option_gys() {
        $arr = self::where(['type'=>'1'])->column('cname', 'id');
        return \my::option($arr);
    }
    //产品分类调用
    static function option_fl() {
        $rst = self::where(['type'=>'2','pid'=>'0'])->order('listorder desc,id asc')->select();
        $html = '';
        $hasQuit = false;
        foreach ($rst as $row) {
            $rsts = self::where('pid',$row->id)->order('listorder desc,id asc')->select();
            //查询是否有二级栏目
            if($rsts){
                $html .= "<option value=\"{$row->id}\" disabled> ﹥ ".($row->cname)."</option>";
            }else{
                if($cid==$row->id){
                    $html .= "<option value=\"{$row->id}\" selected> ﹥ {$row->cname}</option>";
                }else{
                    $html .= "<option value=\"{$row->id}\"> ﹥ {$row->cname}</option>";
                }
                
            }
            foreach ($rsts as $rows) {
                if($cid==$rows->id){
                    $html .= "<option value=\"{$rows->id}\" selected> ﹥ ﹥ {$rows['cname']}</option>";
                }else{
                    $html .= "<option value=\"{$rows->id}\"> ﹥ ﹥ {$rows->cname}</option>";
                }
                
            }
        }
        return $html;
    }
    static public $allName = [];
    // 根据ID返回供应商
    static public function get_cname($id) {
        if (empty($id)) return '';

        if (empty(self::$allName)) {
            self::$allName = self::column('cname','id');
        }

        return self::$allName[$id];
    }
    
}