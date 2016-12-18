<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;

class Goods extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $type = [
		'create_time'=>'timestamp:Y/m/d',
		'birthday' => 'timestamp:Y/m/d',
		];
}