<?php

namespace app\common;
use think\template\TagLib;

class HqTag extends TagLib
{
    protected $tags = [
        // 上传图片
        // {tmdTag:upimg name='logo' /}
        'upimg' => [
            'attr' => 'name',
            'close' => 0,
        ],
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
        
    ];
    function tagUpimg($tag) {
        $id="filelist".mt_rand(1000,9999);
        $idpick="filePicker".mt_rand(1000,9999);
        $ret = <<<EOT
<link rel="stylesheet" type="text/css" href="__INDEX__/webuploader/webuploader.css"><!-- 引用插件css -->
<div id="uploader-demo">
    <!--用来存放item-->
        <div id="{$id}" class="uploader-list">
            
            <input class="{$tag['class']}" type="text" name="{$tag['name']}" value="{$tag['value']}">
        </div>
    <div id="{$idpick}">选择图片</div>
</div>
<script src="__INDEX__/jquery/jquery.min.js"></script>  <!-- 引用jquery -->  
<script type="text/javascript" src="__INDEX__/webuploader/webuploader.js"></script>    <!-- 引用插件js -->
<script type="text/javascript">
           var lists=$("#{$id}");   //这几个初始化全局的百度文档上没说明，好蛋疼
           var thumbnailWidth = 100;   //缩略图高度和宽度 （单位是像素），当宽高度是0~1的时候，是按照百分比计算，具体可以看api文档  
           var thumbnailHeight = 100;  
           var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
           auto: true,
            // swf文件路径
           swf: '/static/webuploader/uploader.swf', //加载swf文件，路径一定要对
            // 文件接收服务端。
            server: '{:url("index/upload/upload")}',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#{$idpick}',
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/'
            }
        });
      //上传完成事件监听
        uploader.on( 'fileQueued', function(file) {
            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    img.replaceWith('<span>不能预览</span>');
                    return;
                }
                img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });
        uploader.on("uploadSuccess", function(file,response) {
            if (response.url=="") {
                alert("上传失败,请刷新页面");
                $("#"+file.id ).find(".info").remove();
                $("#"+file.id ).find(".progress").remove();
            }else{
                $("#{$id} input").val(response.url);//添加URL到输入框
                //alert("上传成功"+response.url);
                $("#"+file.id ).find(".info").remove();
                $("#"+file.id ).find(".progress").remove();
            }
        });
</script>
EOT;
        return $ret;
    }
    
    function tagSelect($tag) {
        $arr = config('select_data.'.$tag['optname']);
        if(empty($tag['noempty'])) {
            $ret = '<option value=\"{$tag[value]}\"></option>';
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
    
}