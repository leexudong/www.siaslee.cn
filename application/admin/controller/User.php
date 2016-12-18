<?php
namespace app\admin\controller;
use app\admin\model\User as users;
use think\Controller;
use think\Request;
use think\Db;
class User extends Controller
{
	
	public function setUser()
	{	
		
		
		//ajax方式跳转
		$request = Request::instance();
		$id = $request->only(['id']);
		$type = $request->only(['type']);
		$t = $type['type'];
		$ids = $id['id'] *1;
		//dump($t);
		//dump($ids);
		$user  = new users;
		//echo json_encode(['status'=>1,'msg'=>'success']);
				//die();
		if($t=='管理员'){
				$result = $user->save(['user_type' => 0],['id' => $ids]);
				if($result){
					echo json_encode(['status'=>1,'ht'=>'设为管理员','type'=>'普通用户','msg'=>'success']);
					die();
				}else{
					echo json_encode(['status'=>0,'ht'=>'设为管理员','type'=>'普通用户','msg'=>'false']);
					die();
				}
				
			}else{

				$r = $user->save(['user_type' => 1],['id' => $ids]);
				if($r){
					echo json_encode(['status'=>1,'type'=>'管理员','ht'=>'设为普通用户','msg'=>'success']);
					die();
				}else{
					echo json_encode(['status'=>0,'type'=>'管理员','ht'=>'设为普通用户','msg'=>'false']);
					die();
				}
				
				
			}

	
	}

	//（软）删除用户
	public function del()
	{
		$request = Request::instance();
		$id = $request->only(['id']);
		$ids = $id['id'] *1;
		//dump($t);
		//dump($ids);
		$user  = new users;
		//echo json_encode(['status'=>1,'msg'=>'success']);
				//die();
		$result = $user->destroy($ids);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'delete success']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'delete false']);
			die();
		}
		
	}

	//从回收站中移出用户
	public function move()
	{
		$request = Request::instance();
		$id = $request->only(['id']);
		$ids = $id['id'] *1;
		$user = new users;
		/*$result = $user->save([
				'delete_time'=>null,
			],['id'=>$ids]);*/
		$result = Db::table('g_user')->where('id',$ids)->update(['delete_time'=>null]);
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
		$uid = $_REQUEST['uidarray'];
		
		foreach ($uid as  $id) {
			$score = $_REQUEST['userScore'][$id];
			/*$fans_num = $_REQUEST['fansNum'][$id];
			$focus_num = $_REQUEST['focusNum'][$id];*/

			//修改
			$user = new users;
			// save方法第二个参数为更新条件
			$u = $user->save([
			'score' => $score,
			/*'fans_num' => $fans_num,
			'focus_num' => $focus_num*/
			],['id' => $id]);
			}
			if($u){
				$this->success('修改成功啦');
			}else{
				$this->false('修改失败');
			}
		
	}

	//真正删除用户
	public function delTrue()
	{	
		//定义了软删除之后的用户就不能真正删除了
		$request = Request::instance();
		$ids = $request->only(['id']);
		$id = $ids['id'] *1;
		$user  = new users;
		$result = $user->destroy($id,true);
		if($result){
			//$this->success("您成功删除了id为".$id."的用户");
			echo json_encode(['status'=>1,'msg'=>'delete success']);
			die();
		}else{
			//$this->false('删除失败');
			echo json_encode(['status'=>0,'msg'=>'delete false']);
			die();
		}
		
	}

}