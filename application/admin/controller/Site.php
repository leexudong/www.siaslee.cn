<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Site as sites;

class Site extends Controller
{
	public function set()
	{
		$stitle = $_REQUEST['stitle'];
		$surl = $_REQUEST['surl'];
		$sdescription = $_REQUEST['sdescription'];
		$s_name = $_REQUEST['s_name'];
		$s_phone = $_REQUEST['s_phone'];
		$s_qq = $_REQUEST['s_qq'];
		$s_email = $_REQUEST['s_email'];
		$s_address = $_REQUEST['s_address'];
		$scopyright = $_REQUEST['scopyright'];
		$sid = $_REQUEST['sid'];
		//dump($s_email);
		$site = new sites;
		$result = $site->save([
				'title' =>$stitle,
				'domain_name'=>$surl,
				'site_describe'=>$sdescription,
				'linkman_name'=>$s_name,
				'phone'=>$s_phone,
				'qq'=>$s_qq,
				'email'=>$s_email,
				'address'=>$s_address,
				'site_information'=>$scopyright


			],['id'=>$sid]);
		if($result){
			$this->success('更新成功');
		}else{
			$this->error('更新失败');
		}
	}
}