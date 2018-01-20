<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class Column extends BaseModel
{
    protected $type = [
        'addtime' => 'timestamp',
        'auth' => 'array'
    ];

    protected function base($query)
    {
        //$query->where('system.id', '1');
    }
    
    //进行分类处理
    public function peer($data){
        return \cate::peer($data);
    }
    
    static function option() {
        $arr = self::where('pid','=','0')->column('cname', 'id');
        //查询对应
        return \my::option($arr);
    }
    //栏目页掉用
    static function option_column($cid) {
        //$arr = self::where(['type'=>'1','pid'=>'0'])->column('name', 'id');
        //$arr = self::order('id desc')->column('name,pid','id');
        //$arr = \app\admin\model\Column::peer($arr);
        //筛选出一级栏目
        $rst = self::where('pid','0')->order('listorder desc,id asc')->select();
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
        //return \my::option_article($rst);
    }
    //发布文章调用
    static function option_article($cid) {
        //$arr = self::where(['type'=>'1','pid'=>'0'])->column('name', 'id');
        //$arr = self::order('id desc')->column('name,pid','id');
        //$arr = \app\admin\model\Column::peer($arr);
        //筛选出一级栏目
        $rst = self::where(['type'=>'1','pid'=>'0'])->order('listorder desc,id asc')->select();
        $html = '';
        $hasQuit = false;
        foreach ($rst as $row) {
            $rsts = self::where(['type'=>'1','pid'=>$row->id])->order('listorder desc,id asc')->select();
            //查询是否有二级栏目
            if($rsts){
                $html .= "<option value=\"{$row->id}\" disabled>".($row->cname)."</option>";
            }else{
                if($cid==$row->id){
                    $html .= "<option value=\"{$row->id}\" selected>{$row->cname}</option>";
                }else{
                    $html .= "<option value=\"{$row->id}\">{$row->cname}</option>";
                }
                
            }
            foreach ($rsts as $rows) {
                //if($cid==$rows->id){
                //    $html .= "<option value=\"{$rows->id}\" selected>┗- {$rows['cname']}</option>";
                //}else{
                //    $html .= "<option value=\"{$rows->id}\">┗- {$rows->cname}</option>";
                //} 
                $rstss = self::where(['type'=>'1','pid'=>$rows->id])->order('listorder desc,id asc')->select();
                //查询是否有二级栏目
                if($rstss){
                    $html .= "<option value=\"{$rows->id}\" disabled> ﹥ ".($rows->cname)."</option>";
                }else{
                    if($cid==$rows->id){
                        $html .= "<option value=\"{$rows->id}\" selected> ﹥ {$rows->cname}</option>";
                    }else{
                        $html .= "<option value=\"{$rows->id}\"> ﹥ {$rows->cname}</option>";
                    }

                }
                foreach ($rstss as $rowss) {
                    if($cid==$rowss->id){
                        $html .= "<option value=\"{$rowss->id}\" selected> ﹥ ﹥ {$rowss['cname']}</option>";
                    }else{
                        $html .= "<option value=\"{$rowss->id}\"> ﹥ ﹥ {$rowss->cname}</option>";
                    }

                }
            }
        }
        return $html;
        //return \my::option_article($rst);
    }
    //单页调用
    static function option_page($cid) {
        //$arr = self::where(['type'=>'1','pid'=>'0'])->column('name', 'id');
        //$arr = self::order('id desc')->column('name,pid','id');
        //$arr = \app\admin\model\Column::peer($arr);
        //筛选出一级栏目
        $rst = self::where(['type'=>'2','pid'=>'0'])->order('listorder desc,id asc')->select();
        $html = '';
        $hasQuit = false;
        foreach ($rst as $row) {
            $rsts = self::where(['type'=>'2','pid'=>$row->id])->order('listorder desc,id asc')->select();
            //查询是否有二级栏目
            if($rsts){
                $html .= "<option value=\"{$row->id}\" disabled>".($row->cname)."</option>";
            }else{
                if($cid==$row->id){
                    $html .= "<option value=\"{$row->id}\" selected disabled>{$row->cname}</option>";
                }else{
                    $html .= "<option value=\"{$row->id}\" disabled>{$row->cname}</option>";
                }
                
            }
            foreach ($rsts as $rows) {
                if($cid==$rows->id){
                    $html .= "<option value=\"{$rows->id}\" selected disabled> ﹥ ﹥ {$rows['cname']}</option>";
                }else{
                    $html .= "<option value=\"{$rows->id}\"> ﹥ ﹥ {$rows->cname}</option>";
                }
                
            }
        }
        return $html;
        //return \my::option_article($rst);
    }
    //面包屑
    static function crumbs($cid) {
        //查询当前栏目名称
        $rst = self::where(['id'=>$cid])->find();
        //如果有上级栏目一级
        if($rst['pid']<>'0'){
            //查询上级栏目
            $prst = self::where(['id'=>$rst['pid']])->find();
            //再次查询是否有上级栏目二级
            if($prst['pid']<>'0'){
                //再次查询是否有上级栏目三级
                $pprst = self::where(['id'=>$prst['pid']])->find();
                if($pprst['pid']<>'0'){
                    $html = "当前位置: <a href=\"/\">首页</a> / <a href=\"/index/index/lists?cid=".$pprst['id']."\">".$pprst['cname']."</a> / <a href=\"/index/index/lists?cid=".$prst['id']."\">".$prst['cname']."</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname']."</a>";
                }else{
                    $html = "当前位置: <a href=\"/\">首页</a> / <a href=\"/index/index/lists?cid=".$pprst['id']."\">".$pprst['cname']."</a> / <a href=\"/index/index/lists?cid=".$prst['id']."\">".$prst['cname']."</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname']."</a>";
                }
            }else{
                $html = "当前位置: <a href=\"/\">首页</a> / <a href=\"/index/index/lists?cid=".$prst['id']."\">".$prst['cname']."</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname']."</a>";
            }
        }else{
            $html = "当前位置: <a href=\"/\">首页</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname']."</a>";
        }
        return $html;
        //return \my::option_article($rst);
    }
    //面包屑_英文
    static function crumbs_en($cid) {
        //查询当前栏目名称
        $rst = self::where(['id'=>$cid])->find();
        //如果有上级栏目一级
        if($rst['pid']<>'0'){
            //查询上级栏目
            $prst = self::where(['id'=>$rst['pid']])->find();
            //再次查询是否有上级栏目二级
            if($prst['pid']<>'0'){
                //再次查询是否有上级栏目三级
                $pprst = self::where(['id'=>$prst['pid']])->find();
                if($pprst['pid']<>'0'){
                    $html = "Location: <a href=\"/\">Home</a> / <a href=\"/index/index/lists?cid=".$pprst['id']."\">".$pprst['cname_en']."</a> / <a href=\"/index/index/lists?cid=".$prst['id']."\">".$prst['cname_en']."</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname_en']."</a>";
                }else{
                    $html = "Location: <a href=\"/\">Home</a> / <a href=\"/index/index/lists?cid=".$pprst['id']."\">".$pprst['cname_en']."</a> / <a href=\"/index/index/lists?cid=".$prst['id']."\">".$prst['cname_en']."</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname_en']."</a>";
                }
            }else{
                $html = "Location: <a href=\"/\">Home</a> / <a href=\"/index/index/lists?cid=".$prst['id']."\">".$prst['cname_en']."</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname_en']."</a>";
            }
        }else{
            $html = "Location: <a href=\"/\">Home</a> / <a href=\"/index/index/lists?cid=".$rst['id']."\" class=\"active\">".$rst['cname_en']."</a>";
        }
        return $html;
        //return \my::option_article($rst);
    }
}