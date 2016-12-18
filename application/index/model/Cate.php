<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Cate extends Model
{
	public function postcate($data)
	{
		
			$this->data($data);
			$result = $this->save();
			return $result;
	
	}
	//菜谱信息查询
	public function cateSel($a, $b)
	{

		
		$result = $this->where("$a", "$b")->select();
		return $result;
	}
	//查询所有菜谱
	public function cateAll($a, $b)
	{

		
		$result = $this->where("$a",'>',"$b")->limit(18)->select();
		return $result;
	}
	//菜谱分类查询
	public function cateClass($a, $b)
	{

		
		$result = $this->where("$a",'>',"$b")->limit(20)->select();
		return $result;
	}
	public function doEdit($data, $if)
	{
		
			
			$result = $this->save($data, $if);
			return $result;
	
	}

}