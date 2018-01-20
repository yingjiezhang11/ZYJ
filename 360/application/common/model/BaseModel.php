<?php
namespace app\common\model;

use think\Model;
//use traits\model\SoftDelete;

class BaseModel extends Model{
    //use SoftDelete;
    protected $dateFormat = 'Y-m-d H:i';


    function getCreateTimeAttr($value) {
        return \my::dtFmt($value);
    }

    function getUpdateTimeAttr($value) {
        return \my::dtFmt($value);
    }
}