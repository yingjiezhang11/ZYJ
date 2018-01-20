<?php

namespace app\weixin\model;

use app\admin\model\System as myModel;
use app\common\model\BaseModel;
use think\Db;
class Message extends BaseModel
{
    protected $type = [
        'auth' => 'array'
    ];

    protected function base($query)
    {
        //$query->where('system.id', '1');
    }
    //跟进提醒
    static function tixing($openid,$company,$username,$type,$remark,$url){
        $template=array(
            'touser'=>$openid,
            'template_id'=>"MDgHg1cRlyiR4wcO9DBc2ND3avS7kfC8bYJdOckfRr0",
            'url'=>$url,
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode("客户<".$company.">有最新的跟进信息！"),'color'=>"#0d6c33"),
                'keyword1'=>array('value'=>urlencode($username),'color'=>'#0d6c33'),
                'keyword2'=>array('value'=>urlencode($type),'color'=>'#0d6c33'),
                'keyword3'=>array('value'=>urlencode(date('Y-m-d h:i:s',time())),'color'=>'#0d6c33'),
                'keyword4'=>array('value'=>urlencode($remark),'color'=>'#0d6c33'),
                'remark'=>array('value'=>urlencode('请及时协助跟进该客户相关情况!'),'color'=>'#0d6c33')
            )
        );
        $accesstoken= \app\weixin\model\WxUser::accesstoken(1);
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accesstoken;
        $res=\my::http_curl($url,urldecode($json_template));
    }
    
}