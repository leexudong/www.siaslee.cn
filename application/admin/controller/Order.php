<?php
namespace app\admin\controller;
use app\admin\model\Order as orders;
use think\Controller;
use think\Request;
use think\Db;
class Order extends Controller
{
	public function set()
	{
		$id = $_REQUEST['oid'] *1;
		$status = $_REQUEST['status'];
		//dump($status);
		$order = new orders;
		if($status=='待发货'){
			$result = $order->save(['status'=>1],['id'=>$id]);
			if($result){
				echo json_encode(['status'=>1,'show'=>'已发货']);
				die();
			}else{
				echo json_encode(['status'=>0,'msg'=>'发货失败']);
				die();
			}
		}elseif($status=='已发货'){
			$result = $order->save(['status'=>2],['id'=>$id]);
			if($result){
				echo json_encode(['status'=>1,'show'=>'已签收']);
				die();
			}else{
				echo json_encode(['status'=>0,'msg'=>'签收失败']);
				die();
			}
		}else{
			echo json_encode(['status'=>0,'msg'=>'已签收不可更改']);
			die();
		}
	}

	//放入回收站
	public function del()
	{
		$id = $_REQUEST['gid'];
		// $topic = new Topic;
		$order = new orders;
		$result = $order->destroy($id);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'订单放入回收站成功']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'订单放入回收站失败']);
			die();
		}
	}
	
	//移出回收站
	public function move()
	{
		$request = Request::instance();
		$id = $request->only(['id']);
		$ids = $id['id'] *1;
		//dump($ids);
		$result = Db::table('g_order')->where('id',$ids)->update(['delete_time'=>null]);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'renew success']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'renew false']);
			die();
		}
	}
	
}