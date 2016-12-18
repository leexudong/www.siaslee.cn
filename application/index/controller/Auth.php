<?php
/**
 * 这是一个认证控制器
 */

namespace app\index\controller;
use think\Controller;
use think\Model;
use think\Request;
use think\Session;
use think\Db;
use app\index\model\Cateblock;
use app\index\model\User;
use app\index\model\Cate;
use app\index\model\Step;
use app\index\model\Meterials;
use app\index\model\Collect;
use app\index\model\Catecomment;
class Auth extends Controller
{
	public $user;
	public $cateblock;
	public $username;
    public $photo;
    public $uid;
    public $cate;
    public $meterials;
    public $step;
    public $collect;
    public $catecomment;
    public $usertype;
	public function __construct(Request $request)
	{
		parent::__construct();


		$this->user = new user();
		$this->cate = new Cate();
		$this->meterials = new Meterials();
		$this->cateblock = new Cateblock();
		$this->step = new Step();
		$this->collect = new Collect();
		$this->catecomment = new Catecomment();
		//得到session值
		$this->photo = Session::get('photo');
		$this->username = Session::get('username');
		$this->uid = Session::get('uid');
		$this->usertype = Session::get('usertype');

		$this->assign('usertype', $this->usertype);
		$this->assign('photo', $this->photo);
		$this->assign('uid', $this->uid);
		$this->assign('username', $this->username);

		//头版块查询
		$data1 = $this->cateblock->blockSel('pid', '1');
		$this->assign('data1', $data1);
		$health= $this->cateblock->blockSel('pid', '2');
		$this->assign('health',  $health);
		
		if($this->checkLogin()){
			$result = $this->user->loginSel('id',"$this->uid");
			$photo = $result->photo;

			$this->assign('result', $result);
			$this->assign('photo', $photo);
		}
		
		// $cate = $this->cate->cateSel('user_id', "$this->uid");
		// $this->assign('cate', $cate);
		// if(!$this->checkLogin() && $request->controller() != 'Auth')
		// {
		// 	$this->error('请登录');
		// }
	}


	public function login()
	{
	// 	$photo = Session::get('photo');
	// 	$this->assign('photo', $photo);
	 	$username = Session::get('username');
	 	$this->assign('username', $username);

		$data1 = $this->cateblock->blockSel('pid', '1');
		$this->assign('data1', $data1);

		$health= $this->cateblock->blockSel('pid', '2');
		$this->assign('health',  $health);

		return $this->fetch();
	}

	public function doLogin()
	{
		
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$result = $this->user->loginSel('username', "$username");
		if($result){
			if($password == $result->password){
				$u = $this->user->where('username',$username)->find();
				$uid = $u['id'];
				$photo = $u['photo'];
				$usertype = $u['user_type'];		
				Session::set('uid',"$uid"); 
				Session::set('username',"$username");
				Session::set('photo',"$photo");
				Session::set('usertype',"$usertype");
				$this->success('登陆成功');
				echo json_encode(['status' => 1, 'msg' => '登陆成功', 'data' => '']);die();
			}else{
				echo json_encode(['status' => 0, 'msg' => '密码错误', 'data' => '']);die();
			}
		}else{
			echo json_encode(['status' => 0, 'msg' => '用户名错误', 'data' => '']);die();
		}
	}

	

	public function register()
	{

		$data1 = $this->cateblock->blockSel('pid', '1');
       $this->assign('data1', $data1);

       $health= $this->cateblock->blockSel('pid', '2');
       $this->assign('health',  $health);
		return $this->fetch();
	}

	public function doRegister()
	{
		$user=new User;
		$username = $_REQUEST['username'];
		$password= md5($_REQUEST['password']);
		
	    $code=$_REQUEST['code'];
	   
		if(captcha_check($code)){
			$data = [
			'username' => "$username",
			'password' => "$password"

			];
			$result = $this->user->register($data);
			 
		 	
		 	if($result){
		 		
		 		
		 		echo json_encode(['status' => 1, 'msg' => '注册成功', 'data' => '']);die();
		 	}else{
		 		echo json_encode(['status' => 0, 'msg' => '注册失败', 'data' => '']);die();
		 	}
		 }else{
		 	echo json_encode(['status' => 0, 'msg' => '验证码错误', 'data' => '']);die();
		 };
		 		
	}
	 public function checkLogin()
    {
      
      return $this->uid;
    }
}
