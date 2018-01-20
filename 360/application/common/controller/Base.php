<?php
namespace app\common\controller;

use \app\admin\model\Log as myModel;
use think\Controller;

class Base extends Controller{

    public function __construct(){
        parent::__construct();

        $user = session('user');

        if (!$user) {
            session('before_login', request()->url());
            $this->redirect('login/index');
        }
        //定义USER_ID
        define('USER_ID', $user['id']);
        define('ROLE_ID', $user['role_id']);

        // 是否超管
        define('IS_ADMIN', ($user['id']==1));
        
        //非超管记录日志
        if(!IS_ADMIN and config('is_log')=='1'){
            //记录日志
            $files=new myModel;
            $request = \think\Request::instance();
            $files['userid']=USER_ID;
            $files['addtime']=time();
            $files['controller']=$request->controller();
            $files['action']=$request->action();
            $files['app']=$request->module();
            $files->save($file);
        }
    }

}