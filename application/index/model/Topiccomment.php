<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Topiccomment extends Model
{
	protected $type = [
		'create_time'=>'timestamp:Y/m/d H:i:s',
		'update_time'=>'timestamp:Y/m/d H:i:s',
		
		];

	public function users()
	{
		return	$this->belongsTo('User','users_id'); 
	}

	public function topic()
	{
		return $this->belongsTo('Topic','topic_id');
	}
}