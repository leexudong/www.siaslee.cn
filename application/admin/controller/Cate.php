<?php
namespace app\admin\controller;
use app\admin\model\Cate as cates;
use app\admin\model\User;
use think\Controller;
use think\Request;
use think\Db;
class Cate extends Controller
{
	//删除
	public function delTrue()
	{
		$id = $_REQUEST['cid'] *1;
		$cate = new cates;
		$result = $cate ->destroy($id,true);	
		if($result){
			echo json_encode(['status'=>1,'msg'=>'删除菜谱成功']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'删除菜谱失败']);
			die();
		}	
	}

	//放入回收站
	public function del()
	{
		$id = $_REQUEST['cid'] *1;
		$cate = new cates;
		$result = $cate ->destroy($id);	
		if($result){
			echo json_encode(['status'=>1,'msg'=>'放入回收站成功']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'放入回收站失败']);
			die();
		}	
	}

	//从回收站中移出
	public function move()
	{
		$request = Request::instance();
		$id = $request->only(['id']);
		$ids = $id['id'] *1;
		$user = new cates;
		
		$result = Db::table('g_cate')->where('id',$ids)->update(['delete_time'=>null]);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'renew success']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'renew false']);
			die();
		}
	}

	//修改菜谱信息
	public function set()
	{
		$ids = $_REQUEST['cidarray'];
		foreach ($ids as  $id) {
			$title = $_REQUEST['cateTitle'][$id];
			$difficulty = $_REQUEST['cateDiff'][$id];
			$cook_time = $_REQUEST['cookTime'][$id];
			$ready_time = $_REQUEST['readyTime'][$id];

			$cate = new cates;
			$result = $cate ->save([
				'cate_title'=>$title,
				'difficulty'=>$difficulty,
				'ready_time'=>$ready_time,
				'cook_time'=>$cook_time],
				
				['id'=>$id]);
		}
		if($result){
			$this->success('修改菜谱信息成功');
		}else{
			$this->false('修改菜谱信息失败');
		}
	}
}
