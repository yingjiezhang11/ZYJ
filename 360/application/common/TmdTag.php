<?php

namespace app\common;
use think\template\TagLib;

class TmdTag extends TagLib
{
    protected $tags = [
        // 上传图片
        // {tmdTag:upimg name='logo' /}
        'upimg' => [
            'attr' => 'name',
            'close' => 0,
        ],
        // 上传图片
        // {tmdTag:upimg name='logo' /}
        'upimgmember' => [
            'attr' => 'name',
            'close' => 0,
        ],
        // 日期 年月日 2016-11-22
        // {tmdTag:date name='asd' /}
        'date' => [
            'attr' => 'name',
            'close' => 0,
        ],
        // 日期 年月日 2016-11-22 20:10
        // {tmdTag:date name='asd' /}
        'datetime' => [
            'attr' => 'name',
            'close' => 0,
        ],
        // 时间 11:22
        // {tmdTag:time name='asd' /}
        'time' => [
            'attr' => 'name',
            'close' => 0,
        ],
        'year'  =>  [
            'attr'  =>  'name',
            'close' =>  0
        ],

        // 时间区 01:22 11:22
        // {tmdTag:timeRange name1='time_open' name2='time_close' /}
        'timerange' => [
            'attr' => 'name1,name2',
            'close' => 0,
        ],
        'daterange' => [
            'attr'  =>  'name1,name2',
            'close' =>  0
        ],
        // 地图坐标 j经 w纬
        // {tmdTag:map namej='asd' namew='' /}
        'map' => [
            'attr' => 'namej,namew',
            'close' => 0,
        ],

        // 单选
        // {tmdTag:select name='type' optname='shop_type' /}
        'select' => [
            'attr' => 'name,optname,noempty',
            'close' => 0,
        ],
        // 多选
        // {tmdTag:selectMany name='type' optname='shop_type' /}
        'selectmany' => [
            'attr' => 'name,optname',
            'close' => 0,
        ],
        'editor' => [
            'attr' => 'name',
            'close' => 0,
        ],
    ];
    function tagUpimg($tag) {
        $ret = <<<EOT
<div class="input-group">
    <input type="text" class="form-control" name="{$tag['name']}">
    <span class="input-group-btn">
        <button class="btn btn-default tmdUpload-upload" type="button">上传</button>
        <button class="btn btn-default tmdUpload-show" type="button">查看</button>
        <button class="btn btn-default tmdUpload-delete" type="button">删除</button>
    </span>
</div>
EOT;
        return $ret;
    }
    function tagUpimgmember($tag) {
        $ret = <<<EOT
<div class="input-group">
    <input type="text" class="form-control" name="{$tag['name']}">
    <span class="input-group-btn">
        <button class="btn btn-default tmdUpload-upload-member" type="button">上传</button>
    </span>
</div>
EOT;
        return $ret;
    }
    function tagDate($tag) {
        $ret = <<<EOT
<input type="text" class="form-control tmdDate" name="{$tag['name']}">
EOT;
        return $ret;
    }
    function tagDatetime($tag) {
        $ret = <<<EOT
<input type="text" class="form-control tmdDatetime" name="{$tag['name']}">
EOT;
        return $ret;
    }
    function tagTime($tag) {
        $ret = <<<EOT
<input type="text" class="form-control tmdTime" name="{$tag['name']}">
EOT;
        return $ret;
    }
    function tagYear($tag) {
        $ret = <<<EOT
<input type="text" class="form-control tmdYear" name="{$tag['name']}">
EOT;
        return $ret;
    }
    function tagTimeRange($tag) {
        $ret = <<<EOT
<div class="input-group">
    <input type="text" class="form-control tmdTime" name="{$tag['name1']}">
    <span class="input-group-addon fix-border">-</span>
    <input type="text" class="form-control tmdTime" name="{$tag['name2']}">
</div>
EOT;
        return $ret;
    }
    function tagDateRange($tag) {
        $ret = <<<EOT
    <input type="text" class="form-control tmdDate" name="{$tag['name1']}">
    <span>-</span>
    <input type="text" class="form-control tmdDate" name="{$tag['name2']}">
EOT;
        return $ret;
    }
    function tagMap($tag) {
        $ret = <<<EOT
<div class="input-group">
    <span class="input-group-addon">经</span>
    <input type="text" class="form-control" name="{$tag['namej']}">
    <span class="input-group-addon fix-border">纬</span>
    <input type="text" class="form-control" name="{$tag['namew']}">
    <span class="input-group-btn">
      <button class="btn btn-default tmdMap-mark" type="button">标注</button>
    </span>
</div>
EOT;
        return $ret;
    }

    function tagSelect($tag) {
        $arr = config('select_data.'.$tag['optname']);
        if(empty($tag['noempty'])) {
            $ret = '<option value=""></option>';
        }else{
            $ret = '';
        }
        foreach ($arr as $k=>$v) {
            $ret .= "<option value=\"$k\">$v</option>";
        }
        $ret = "<select name=\"{$tag['name']}\" class=\"mySelect form-control\">" . $ret . '</select>';
        return $ret;
    }

    function tagSelectMany($tag) {
        $arr = config('select_data.'.$tag['optname']);
        $ret = '';

        foreach ($arr as $k=>$v) {
            $ret .= "<option value=\"$k\">$v</option>";
        }
        $ret = "<select name=\"{$tag['name']}[]\" class=\"mySelect form-control\" multiple>" . $ret . '</select>';
        return $ret;
    }

    function tagEditor($tag) {
        static $isLoad = false;
        $ret = '';
        if (!$isLoad) {
            $ret .= '<link rel="stylesheet" href="__INDEX__/wangEditor/css/wangEditor.min.css"/>
<script src="__INDEX__/wangEditor/js/wangEditor.js"></script>
';
            $isLoad = true;
        }
        $id = 'editor_'.mt_rand(1000,9999);
        $ret .= <<<EOT
<textarea name="{$tag['name']}" id="{$id}" class="form-control" style="height: 400px"></textarea>
<script>
$(function(){
    var {$id} = new wangEditor('{$id}');
    {$id}.create();
    {$id}.onchange = function () {
        var tmp = this.\$txt.html();
        $('#{$id}').val(tmp); 
    };
});
</script>
EOT;
        return $ret;
    }

//    static function split($str) {
//        if (empty($str)) {
//            return [];
//        }
//        $arr = preg_split('/\s*[,\x{ff0c}]+\s*/u', trim($str));
//        $arr = array_unique(array_filter($arr));
//        return $arr;
//    }
}