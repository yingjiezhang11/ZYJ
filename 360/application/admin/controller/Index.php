<?php

namespace app\admin\controller;
use app\common\controller\Base;

class Index extends Base
{
    function index(){
        return view();
    }
    //地图标注
    function mapMark() {
        return view('mapMark', [

        ]);
    }
}