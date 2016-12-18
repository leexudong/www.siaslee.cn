<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class User extends Model
{
	//用户注册
	public function register($data)
	{
			$this->data($data);
			$result = $this->save();
			return $result;
	}
	//登陆信息查询
	public function loginSel($a,$b)
	{
		$result = $this->where("$a", "$b")->find();
		return $result;
		
	}
	//修改个人信息
	public function updateInfo($data,$if)
	{
		
		$result = $this->save($data,$if);
		return $result;
		
	}
	//更改头像
	public function updateHead($data,$if)
	{
		

		$result = $this->save($data,$if);
		return $result;
		
	}
	//用户信息查询
	public function userInfo($a,$b)
	{
		$result = $this->where("$a", "$b")->find();
		return $result;
		
	}
	
	
}