<?php
namespace app\index\model;
use think\Model;

use traits\model\SoftDelete;
class Step extends Model
{
	public function addStep($data)
	{
		
			$this->data($data);
			
			$result = $this->save();
			return $result;
			
	
	}

	public function stepEdit($data, $if)
	{
		
			
			$result = $this->save($data, $if);
			return $result;
	
	}
}