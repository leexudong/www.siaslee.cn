<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Order extends Model
{
	use SoftDelete;
	protected $type = [
		'create_time'=>'timestamp:Y/m/d h:i:s',
		'update_time'=>'timestamp:Y/m/d h:i:s',
		];

	public function getStatusAttr($value)
	{
		$status = [0=>'待发货',1=>'已发货',2=>'已签收'];
		return $status[$value];
	}

	public function user()
	{
		return $this->belongsTo('User','user_id','id');
	}
}