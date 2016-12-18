<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class User extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $type = [
		'create_time'=>'timestamp:Y/m/d',
		'birthday' => 'timestamp:Y/m/d',
		];

	public function getUserTypeAttr($value)
	{
		$user_type = [1=>'管理员',0=>'普通用户'];
		return $user_type[$value];
	}

	public function order()
	{
		return $this->hasMany('Order','user_id');
	}

	//用户和菜谱之间的一对多的关联关系
	public function cate()
	{
		return $this->hasMany('Cate','user_id');
	}

	
}