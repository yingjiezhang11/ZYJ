<?php
namespace app\index\controller;

use thinkController;
use app\index\model\User as userModel;
class User extends Common
{
	public function psdedit()
	{
		if(request()->ispost())
		{
			$data = input('post.');
			//dump($data);die;
			$user = new userModel();
			$result = $user->detectpwd(md5($data['password1']));
			if($result == 0)
				$this->error('您输入的原密码有误！');
			if($result == 1)
			{
				$pwd = userModel::get(session('user_id'));
				$pwd['password'] = md5($data['password2']);
				$pwd->save();
				$this->success('修改密码成功！',url('index/index'));
			}
		}
		return view();
	}
}
?>