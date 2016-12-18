<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Order extends Model
{
	protected $type = [
		'create_time'=>'timestamp:Y/m/d H:i:s',
		'update_time'=>'timestamp:Y/m/d H:i:s',
		
		];

	public function getStatusAttr($value)
	{
		$status = [0=>'待发货',1=>'已发货','2'=>'已签收'];
		return $status[$value];
	}	

	
}