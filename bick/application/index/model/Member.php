<?php
namespace app\index\model;
use think\Model;

class Member extends Model
{
	public function team()
	{
		return $this->belongsTo('Team');
	}


}
?>