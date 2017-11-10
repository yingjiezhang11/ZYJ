<?php
namespace app\index\model;
use think\Model;
class Index extends Model
{

  	public function getindexnews($rec){
  	$count=0;
   	$res=Model('View1News')->where('rec',$rec)->paginate(10);
   	//dump($res);die;
   	$count=Model('View1News')->where('rec',$rec)->count();
   	//dump($count);die;
    for($i=0; $i<$count; $i++) {
    	$oldTime=time()-strtotime($res[$i]['time']);
    	if($oldTime<60) {
    		$newTime=$oldTime.'秒前发布';
    	} else if($oldTime<(60*60)) {
    		$newTime=(int)($oldTime/60).'分钟前发布';
    	} else if($oldTime<(60*60*24)) {
    		$newTime=(int)($oldTime/(60*60)).'小时前发布';
    	} else if($oldTime<(60*60*24*30)) {
    		$newTime=(int)($oldTime/(60*60*24)).'天前发布';
    	} else if($oldTime<(60*60*24*30*12)) {
    		$newTime=(int)($oldTime/(60*60*24*30)).'月前发布';
    	} else {
    		$newTime=(int)($oldTime/(60*60*24*30*12)).'年前发布';
    	}
    	
    	$res[$i]['time']=$newTime;
    }
   	return $res;
   }
   public function getindexteam(){
       $userid=$_SESSION['think']['user_id'];
       $team=Model('User')->get(['user_id' => $userid])->team;
       return $team;     
   }
   
}
