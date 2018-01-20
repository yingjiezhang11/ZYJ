<?php
namespace app\index\controller;

use EasyWeChat\Foundation\Application;
use app\admin\model\Upload as myModel;

class Upload
{
    public function index()
    {
        
        return view();
    }
    function upload(){
        $file = request()->file('file');
        $info = $file
            ->validate([
                'size' => 5*1024*1024,
                'ext' => 'png,jpg,gif,jpeg'
            ])
//            ->rule('md5')
            ->move(config('upload.path'));

        if($info){
//            echo config('upload.url') . $info->getSaveName();
            //获取文件大小
            //写入数据库
            $request = \think\Request::instance();
            $files=new myModel;
            $files['userid']=USER_ID;
            $files['addtime']=time();
            $files['filename']=$info->getSaveName();
            $files['controller']=$request->controller();
            $files['action']=$request->action();
            $files['app']=$request->module();
            $files['filetype']='';
            $files['filesize']='';
            $files->save($file);
            return json([
                'url' => config('upload.url') . $info->getSaveName(),
                'path' => $info->getSaveName(),
            ]);
        }else{
//            echo "error|" . $file->getError();
            \my::error($file->getError());
        }

    }
    
}
  