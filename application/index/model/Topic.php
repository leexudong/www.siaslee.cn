<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Topic extends Model
{	
	protected $type = [
		'create_time'=>'timestamp:Y/m/d H:i:s',
		'update_time'=>'timestamp:Y/m/d H:i:s',
		
		];

	//user表和topic表之间一对多的相对关联信息
	public function user()
	{
		return $this->belongsTo('user','user_id');
	}

	//topic表和topiccomment表之间一对多的关联信息
	public function topiccomment()
	{
		return $this->hasMany('Topiccomment','topic_id','id');
	}

	
}