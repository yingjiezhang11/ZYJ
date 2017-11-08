<?php
namespace app\index\model;
use think\Model;
class Record extends Model {

	public function getRecord() {
		$user_id=$_SESSION['think']['user_id'];
		$team_id=db('team')->where('user_id', $user_id)->value('team_id');
		$presenter=db('team')->where('team_id', $team_id)->value('name');
		$record=$this->where('team_id', $team_id)->order('record_id','desc')->select();
		foreach ($record as $data) {
			$data['time']=date("Y-m-d H:i:s",$data['time']); 
			$data['presenter']=$presenter;
		}
		return $record;
	}

	public function getFile($record_id) {
		$record=$this::get(['record_id' => $record_id]);
		$route=$record['route'];
		if(!$route) {
			return false;
		}
		$route=iconv('utf-8', 'GBK', $route);
		//dump($route);
		$file=fopen($route,"r");
	    //dump($file);die;
		$fileinfo = pathinfo($route);
		$filename= $record['title'];//.$fileinfo['extension']  文件拓展名；
		header("Content-Type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".filesize($route));
		header("Content-Disposition: attachment; filename=$filename");
		echo fread($file,filesize($route));
		fclose($file);
	}
	protected static function init() {
		Record::event('before_insert',function($record){
			$userid=$_SESSION['think']['user_id'];
         	$team=Model('User')->get(['user_id' => $userid])->team;
         	$teamid=$team->team_id;
         	//dump($record);die;
         	//dump($_FILES['upload']['name']);die;
         	$teamname=db('team')->where('team_id', $teamid)->value('name');
         	
          if($_FILES['upload']['name']){
                $filename=iconv('UTF-8','GBK',$_FILES['upload']['name']);
                $file = request()->file('upload');
                $info = $file->rule('uniqid')->validate(['ext' => 'doc,pdf,docx,xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'uploads'.DS . $teamname. DS .'record',$filename);

                if($info){
                    // $thumb=ROOT_PATH . 'public' . DS . 'uploads'.'/'.$info->getExtension();
                    //$thumb='uploads'.'/'.$teamname.'/'.'record'.'/'.$info->getSaveName();
                    $filename=iconv('GBK', 'UTF-8', $filename);
                    $thumb='uploads'.'/'.$teamname.'/'.'record'.'/'.$filename;
                    //dump($filename);
                    //dump($thumb);die;
                    //dump($thumb);die;
                    $record['route']=$thumb;
                    $record['title']=$_FILES['upload']['name'];
                }
                else {
                	return false;
                }
          } 
          else {
               return false;
          }
      });
	}
}