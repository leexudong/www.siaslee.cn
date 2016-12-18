<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Meterials extends Model
{
	public function addMeterials($data)
	{	
			$this->data($data);			
			$result = $this->save();
			return $result;
	}
	public function zlEdit($data, $if)
	{
		
			
			$result = $this->save($data, $if);
			return $result;
	
	}
	public function flEdit($data, $if)
	{
		
			
			$result = $this->save($data, $if);
			return $result;
	
	}
	
}