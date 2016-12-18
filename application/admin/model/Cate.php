<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Cate extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $type = [
		'create_time'=>'timestamp:Y/m/d',
		
		];
	//用户和菜谱之间一对多的关系的相对关联
	public function user()
	{
		//return $this->belongsTo('User','user_id');
		//return $this->belongsTo('User');
		return $this->belongsTo('User','user_id');
		
	}
}