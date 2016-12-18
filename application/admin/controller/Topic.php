<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Topic as top;
use think\Request;
use think\Db;
class Topic extends Controller
{
	//真正删除
	public function delTrue()
	{
		$id = $_REQUEST['tid'];
		$topic = new top;
		$result = $topic->destroy($id,true);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'删除话题成功']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'删除话题失败']);
			die();
		}
	}

	//放入回收站
	public function del()
	{
		$id = $_REQUEST['tid'];
		$topic = new top;
		$result = $topic->destroy($id);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'删除话题成功']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'删除话题失败']);
			die();
		}
	}

	//从回收站中移出
	public function move()
	{
		$request = Request::instance();
		$id = $request->only(['id']);
		$ids = $id['id'] *1;
		
		$result = Db::table('g_topic')->where('id',$ids)->update(['delete_time'=>null]);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'renew success']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'renew false']);
			die();
		}
	}
	public function set()
	{
		$ids = $_REQUEST['tidarray'];
		$topic = new top;
		foreach ($ids as $id) {
			$topicTitle = $_REQUEST['topicTitle'][$id];
			$hits = $_REQUEST['hits'][$id];
			$comment_num = $_REQUEST['commentNum'][$id];

			$result = $topic ->save([

					'title' =>$topicTitle,
					'hits' =>$hits,
					'comment_num' =>$comment_num
				],['id'=>$id]);

		}
		if($result){
			$this->success('修改话题成功');
		}else{
			$this->false('修改话题失败');
		}
	}
}