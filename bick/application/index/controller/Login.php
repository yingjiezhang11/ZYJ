<?php

namespace app\index\controller;

use think\Controller;
//use weather;
use app\index\model\User;

class Login extends Controller
{
	public function index()
    {
        $bmdeadline = db('conf')->where('enname','BMdeadline')->find();
        //dump($bmdeadline);die;
        if(request()->isPost()){
            $this->check(input('code'));
            //dump(input('post.'));die;
        	$user = new User();
            //dump($user->select());die;
        	$num=$user->login(input('post.'));
            //dump($num);die;
        	if($num==1){
        		$this->error('用户不存在！');
        	}
        	if($num==2){
        		$this->success('登录成功！',url('index/index'));
        	}
        	if($num==3){
        		$this->error('密码错误！');
        	}
        	return;
        }
        $this->assign('bmdeadline',$bmdeadline);
        return view();
    }

    // 验证码检测
    public function check($code='')
    {
        if (!captcha_check($code)) {
            $this->error('验证码错误');
        } else {
            return true;
        }
    }

     public function register()
     {
        $schoolinfo = db('admin')->field('school')->select();
        foreach ($schoolinfo as $k=> $s) {
           if($s['school']=="0")
            unset($schoolinfo[$k]);
        }
        $this->assign('schoolinfo',$schoolinfo);
        if(request()->isPost()){
            $data = input('post.');
            //dump($data);die;
            $user = new User();

            $user['name'] = $data['name1'];
            $user['password'] = md5($data['password']);
            if($user->save())
            {
                $team['name'] = $data['name2'];
                $team['school'] = $data['school'];
                $team['project'] = $data['project'];
                $team['phone'] = $data['phone'];
                if($user->team()->save($team)){
                    //dump($user->team);die;
                    $m = $user->team;
                    $member = new MemberModel();
                    $list = [
                            ['role'=>1,'team_id'=>$m['team_id'],'school'=>$m['school']],
                            ['role'=>2,'team_id'=>$m['team_id'],'school'=>$m['school']],
                    ];
                    $member->saveall($list);

                    $approval = new Approval();
                    $list2 = [
                            ['type'=>1,'team_id'=>$m['team_id'],'school'=>$m['school'],'time'=>time(),'status'=>0],
                            ['type'=>2,'team_id'=>$m['team_id'],'school'=>$m['school'],'time'=>time(),'status'=>-1],
                    ];
            
                    $approval->saveall($list2);

                    $material = new Material();
                    $list3 = [
                            ['title'=>'研究综述','status'=>'未提交','team_id'=>$m['team_id'],'time'=>time()],
                            ['title'=>'竞赛设计及详细技术路线','status'=>'未提交','team_id'=>$m['team_id'],'time'=>time()],
                            ['title'=>'论文','status'=>'未提交','team_id'=>$m['team_id'],'time'=>time()],

                    ];
            
                    $material->saveall($list3);

                    $this->success('注册成功！',url('login/index'));
                }
                else
                    $this->error('注册失败！');
            }  
        }
        return view();
     }

    
}
