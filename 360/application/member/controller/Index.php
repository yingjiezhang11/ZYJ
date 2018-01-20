<?php

namespace app\member\controller;
use app\common\controller\MemberBase;

class Index extends MemberBase
{
    function index(){
        //判断是否
        return view();
    }
    //地图标注
    function mapMark() {
        return view('mapMark', [

        ]);
    }
}