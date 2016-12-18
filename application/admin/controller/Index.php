<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use app\admin\model\Cate;
use app\admin\model\Topic;
use app\admin\model\Goods;
use app\admin\model\Order;
use app\admin\model\Site;
use think\Db;
use think\Request;
use think\Model;
use think\Session;
class Index extends Controller
{
	//后台首页模块
	public function index()
	{	
		
		if(empty(Session::get('uid'))){
			$this->error('请登录','__SITE__/admin/index/loginout');
		}else{
			return $this->fetch('index');
		}
		
	} 
	public function info()
	{
		$siteData = new Site;
		$list = $siteData->where('id','>',0)->select();
		$this->assign('list',$list);
		return $this->fetch('info');
	}
	//后台用户管理模块
	public function user()
	{	
		$user = new User;   
		

		$count = $user->count();
		$this->assign('count',$count); //多少条可用用户
		$deleteCount = $user->onlyTrashed()->count();
		$this->assign('deleteCount',$deleteCount); //多少条不可用用户
		

		// 查询可用用户数据 并且每页显示10条数据 
		$list = $user->where('id','>=',1)->paginate(5);
		// 查询不可用用户数据 并且每页显示10条数据 
		$deleteUser = $user->onlyTrashed()->paginate(5);
		//$deleteUser = $user->where('delete_time','<>',null)->paginate(5);
		// 获取分页显示
		$page = $list->render();
		$twopage = $deleteUser->render();
		// 模板变量赋值
		$this->assign('list', $list);
		$this->assign('page', $page);
		$this->assign('deleteUser',$deleteUser);
		$this->assign('twopage',$twopage);
		// 渲染模板输出
		return $this->fetch('user');
	}

	//后台菜谱管理模块
	public function cate()
	{	
		$cate = new Cate;

		//多少条未放入回收站的菜谱
		$count = $cate->count();
		$this->assign('count',$count); 


		//多少条放入回收站菜谱
		$deleteCount = $cate->onlyTrashed()->count();
		$this->assign('deleteCount',$deleteCount); 
		
		// 查询未被删除且未放入回收站的菜谱数据  分页显示
		$list = $cate->where('id', '>', 0)->paginate(5);
		$page = $list->render();
		//dump($list);
		//分配模板变量
		$this->assign('list', $list);
		$this->assign('page', $page);
		//dump($list);
		/*foreach ($list as $value) {
			$data = $value->user;
			dump($data);
		}
*/
		// 获取放入回收站的菜谱数据  分页显示
		$deleteCate = $cate->onlyTrashed()->paginate(5);
			
		$twopage = $deleteCate->render();

		// 模板变量赋值
		$this->assign('deleteCate',$deleteCate);
		$this->assign('twopage',$twopage);

		// 渲染模板输出
		return $this->fetch('cate');
	}

	/*//后台首页轮播管理模块
	public function adv()
	{	
		return $this->fetch('adv');
	}*/

	//后台话题管理模块
	public function topic()
	{	
		$topic = new Topic;
		

		//多少条未删除 未放入回收站的话题  分页显示
		$count = $topic->count();
		$this->assign('count',$count); 

		$list = $topic->where('id','>',0)->paginate(5);
		$page = $list->render();

		$this->assign('list',$list);
		$this->assign('page',$page);
		//dump($list);
		/*foreach ($list as  $value) {
			dump($value->user);
		}*/
		//放入回收站的话题   分页显示
		$deleteCount = $topic->onlyTrashed()->count();
		$this->assign('deleteCount',$deleteCount);

		$deleteTopic = $topic->onlyTrashed()->paginate(5,true,[
				'type' => 'bootstrap',
				'var_page' => 'twopage',
			]);
			
		$twopage = $deleteTopic->render();
		$this->assign('deleteTopic',$deleteTopic);
		$this->assign('twopage',$twopage);

		return $this->fetch('topic');
	}

	//后台商品管理模块
	public function goods()
	{
		$goods = new Goods;
		$count = $goods ->count();
		$this->assign('count',$count);

		$list = $goods->where('id','>',0)->paginate(10);
		$page = $list->render();

		$this->assign('list',$list);
		$this->assign('page',$page);
		//dump($page);
		//放入回收站的话题   分页显示
		$deleteCount = $goods->onlyTrashed()->count();
		$this->assign('deleteCount',$deleteCount);

		$deleteGoods = $goods->onlyTrashed()->paginate(10);
			
		$twopage = $deleteGoods->render();
		$this->assign('deleteGoods',$deleteGoods);
		$this->assign('twopage',$twopage);


		return $this->fetch('goods');
	}

	//后台登录模块
	public function login()
	{	

		/*$this->validate($data,[
		'captcha|验证码'=>'require|captcha'
		]);*/
		$code = $_REQUEST['code'];
		if(captcha_check($code)){
			$user = new User;
			$username = $_REQUEST['username'];
			$u = $user->where('username',$username)->find();
			$uid = $u['id'];
			
			if($u){
				if($u['delete_time'] != null){
					$this->error('您已被禁止登录，请与管理员联系恢复','__SITE__/admin/index/loginout');
				}else{
					if($_REQUEST['password']){
					$p = $user->where('username',$username)->find()->password;
					if($p==md5($_REQUEST['password'])){
						$t = $user->where('username',$username)->find()->user_type;
						if($t=='管理员'){
							Session::set('uid',$uid);
							Session::set('username',$username);
							echo json_encode(['status' => 1, 'msg' => '登录成功']);
							die();
						}else{
							echo json_encode(['status' => 0, 'msg' => '该用户不是管理员']);
							die();
						}
					}else{
						echo json_encode(['status' => 0, 'msg' => '密码错误']);
						die();
					}
				}else{
					echo json_encode(['status' => 0, 'msg' => '密码不能为空']);
					die();
				}
				}
				
			}else{
				echo json_encode(['status' => 0, 'msg' => '用户名不存在']);
				die();
			}		
		}else{
			echo json_encode(['status' => 0, 'msg' => '验证码错误']);
			die();
		}
		
	}

	

	//后台退出登录模块
	public function loginout()
	{	
		Session::set('uid','');
		Session::set('username','');
		return $this->fetch('loginout');
	}
	//后台添加商品模块
	public function addGoods()
	{
		return $this->fetch('addGoods');
	}

	//订单管理模块
	public function order()
	{
		$order = new Order;
		//未放入回收站的
		$count = $order->count();
		$this->assign('count',$count);
		$list = $order->where('id','>',0)->paginate(10);
		$page = $list->render();
		$this->assign('list',$list);
		$this->assign('page',$page);
		
		//放入回收站的数据
		
		$delCount = $order->onlyTrashed()->count();
		$this->assign('delCount',$delCount);

		$deleteOrder = $order->onlyTrashed()->paginate(10);
			
		$twopage = $deleteOrder->render();
		$this->assign('deleteOrder',$deleteOrder);
		$this->assign('twopage',$twopage);




		return $this->fetch();
	}
}
