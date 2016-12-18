<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Catecomment extends Model
{
	//收藏
	public function docomment($data)
	{
			$this->data($data);
			$result = $this->save();
			return $result;
	}


}