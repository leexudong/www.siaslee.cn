<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Cateblock extends Model
{
	
	public function blockSel($key,$val)
	{
		

		$result = $this->where("$key", "$val")->select();
		return $result;
	}

}