<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\index\model\Cateblock;
use app\index\controller\common;
class Healtheat extends Auth
{
    
    public function healtheat()
    {
     $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','饮食健康')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','饮食健康')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','饮食健康')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       return $this->fetch();

   
    }
  
     public function bing()
    {
     $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','疾病调理')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','疾病调理')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','疾病调理')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       
       
       //  $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','疾病调理')->paginate(20);
       // //dump($fenLei);
       // $page = $fenLei->render();
       // $this->assign('fenLei', $fenLei);
       //  $this->assign('page', $page);
       return $this->fetch();
    }
     public function zangfu()
    {
      $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','脏腑调理')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','脏腑调理')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','脏腑调理')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       
        
       //  $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','脏腑调理')->paginate(20);
       // //dump($fenLei);
       // $page = $fenLei->render();
       // $this->assign('fenLei', $fenLei);
       //  $this->assign('page', $page);
       return $this->fetch();
    }
     

}
