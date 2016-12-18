<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Collect extends Model
{
	//收藏
	public function shou($data)
	{
			$this->data($data);
			$result = $this->save();
			return $result;
	}

	public function shouSel($a, $b)
	{

		$result = $this->where("$a", "$b")->select();
		return $result;
	}
	
}