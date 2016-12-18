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
class Mylist extends Auth
 {

    public function mylist()
    {
      $request = Request::instance();
      $param = $request->param();
      $user_id = $param['user_id'];
      //c查询用户信息
      $catelist =  Db::name('cate')->where('user_id',"$user_id")->paginate(12);
     //dump($catelist);die();
      $page = $catelist->render();
      $this->assign('page',$page);
      $this->assign('catelist',$catelist);
      $userInfo = $this->user->userInfo('id', "$user_id");
      $this->assign('userInfo',$userInfo);
      
     return $this->fetch();
    }
     public function del()
    {
      $request = Request::instance();
      $param = $request->param();
      $cate_id = $param['cate_id'];
      $del1 = Db::name('cate')->where('id',"$cate_id")->delete();
      $del2 = Db::name('step')->where('cate_id',"$cate_id")->delete();
      $del3 = Db::name('meterials')->where('cate_id',"$cate_id")->delete();

      if($del1 && $del2 && $del3){
         $num =  Db::table('g_user')->where('id', $this->uid)->setDec('cate_num', 1);
        $this->success('删除成功');
      }else{
        $this->error('删除失败');
      }
    
    }

    
}
