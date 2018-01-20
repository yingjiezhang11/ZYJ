<?php
namespace app\index\controller;
class Index
{
    public function index()
    {
       return redirect(url('/member/login/index/'));
         //return view();
         //return redirect(url('/member/index/index/'));
    }

    
}
