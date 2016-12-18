<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\index\model\Cateblock;
use app\index\model\Cate;
use app\index\model\User;
use app\index\controller\common;
class Index extends Auth
 {

    public function index()
    {
     $eighteen= $this->cate->cateAll("id","0");

     $this->assign('eighteen',$eighteen);
     // 用户表和菜谱表关联查询
     $cateList =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->select();
     //dump($cateList);
     //查询用户表,每页显示10个
     $userList =  Db::name('user')->where('id','>',1)->paginate(10);
     foreach($userList as $value)
     {
        $uid = $value['id'];
     
        $count = $this->cate->where('user_id','=',"$uid")->count();
        $num[] = $count;

     }
    // dump($num);die();
     $page = $userList->render();
     //dump($cateList);die();
     //分配相关的变量给前台
     $this->assign('num',$num);
      $this->assign('page',$page);
     $this->assign('userList',$userList);
     $this->assign('cateList',$cateList);
     return $this->fetch();
    }
     public function loginOut()
    {
       
       Session::set('username','');
       Session::set('uid','');
       Session::set('photo','');
       $this->success('退出成功','index/index');
       
       
    }

}
