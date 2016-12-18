<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Topic extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $type = [
		'create_time'=>'timestamp:Y/m/d',
		
		];
	public function user()
	{
		return $this->belongsTo('User','user_id','id');
	}
}