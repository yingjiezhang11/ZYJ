<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class Weixin extends BaseModel
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
        return \my::option($arr);
    }
    //艺人审核
    static function moban_yiren_shenhe($openid,$yirenname){
        $template=array(
            'touser'=>$openid,
            'template_id'=>"Gjplz2bP-GkoNQRpC7FOacCGld51Svv4j4eH3V5RY9s",
            'url'=>$url,
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode("您提交的艺人".$yirenname."审核通过啦！"),'color'=>"#0d6c33"),
                'keyword1'=>array('value'=>urlencode('审核成功'),'color'=>'#0d6c33'),
                'keyword2'=>array('value'=>urlencode(date('Y-m-d',time())),'color'=>'#0d6c33'),
                'remark'=>array('value'=>urlencode('现在该艺人的资料可以正常使用啦!'),'color'=>'#0d6c33')
            )
        );
        $accesstoken= \app\weixin\model\WxUser::accesstoken(1);
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accesstoken;
        $res=\my::http_curl($url,urldecode($json_template));
    }
    //艺人审核拒绝
    static function moban_yiren_jujue($openid,$yirenname){
        $template=array(
            'touser'=>$openid,
            'template_id'=>"Gjplz2bP-GkoNQRpC7FOacCGld51Svv4j4eH3V5RY9s",
            'url'=>$url,
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode("您提交的艺人".$yirenname."被拒绝啦！"),'color'=>"#0d6c33"),
                'keyword1'=>array('value'=>urlencode('审核拒绝'),'color'=>'#0d6c33'),
                'keyword2'=>array('value'=>urlencode(date('Y-m-d',time())),'color'=>'#0d6c33'),
                'remark'=>array('value'=>urlencode('请返回修改资料后再次提交!'),'color'=>'#0d6c33')
            )
        );
        $accesstoken= \app\weixin\model\WxUser::accesstoken(1);
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accesstoken;
        $res=\my::http_curl($url,urldecode($json_template));
    }
    //艺人审核
    static function moban_huodong_shenhe($openid,$yirenname){
        $template=array(
            'touser'=>$openid,
            'template_id'=>"Gjplz2bP-GkoNQRpC7FOacCGld51Svv4j4eH3V5RY9s",
            'url'=>$url,
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode("您提交的活动".$yirenname."审核通过啦！"),'color'=>"#0d6c33"),
                'keyword1'=>array('value'=>urlencode('审核成功'),'color'=>'#0d6c33'),
                'keyword2'=>array('value'=>urlencode(date('Y-m-d',time())),'color'=>'#0d6c33'),
                'remark'=>array('value'=>urlencode('现在可以给该活动推广啦!'),'color'=>'#0d6c33')
            )
        );
        $accesstoken= \app\weixin\model\WxUser::accesstoken(1);
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accesstoken;
        $res=\my::http_curl($url,urldecode($json_template));
    }
    //艺人审核拒绝
    static function moban_huodong_jujue($openid,$yirenname){
        $template=array(
            'touser'=>$openid,
            'template_id'=>"Gjplz2bP-GkoNQRpC7FOacCGld51Svv4j4eH3V5RY9s",
            'url'=>$url,
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode("您提交的活动".$yirenname."被拒绝啦！"),'color'=>"#0d6c33"),
                'keyword1'=>array('value'=>urlencode('审核拒绝'),'color'=>'#0d6c33'),
                'keyword2'=>array('value'=>urlencode(date('Y-m-d',time())),'color'=>'#0d6c33'),
                'remark'=>array('value'=>urlencode('请返回修改资料后再次提交!'),'color'=>'#0d6c33')
            )
        );
        $accesstoken= \app\weixin\model\WxUser::accesstoken(1);
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accesstoken;
        $res=\my::http_curl($url,urldecode($json_template));
    }

}