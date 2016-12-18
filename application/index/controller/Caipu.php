<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\index\model\Cate;
use app\index\model\Cateblock;
use app\index\controller\common;
class Caipu extends Auth
{
    
    public function caipu()
    {
      $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','家常菜谱')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','家常菜谱')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','家常菜谱')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       return $this->fetch();
    }
    public function china()
    {
       $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','中华菜谱')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','中华菜谱')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','中华菜谱')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       return $this->fetch();
    }
    public function guoWai()
    {
       $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','国外菜谱')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','国外菜谱')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','国外菜谱')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       return $this->fetch();
    }
     public function smallEat()
    {
      $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','小吃')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','小吃')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','小吃')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       return $this->fetch();
    }
     public function bake()
    {
      $request = Request::instance();
      $sel = $request->only('sel');
      if($sel == null){
        $select = 0;
      }else{
        $select = $sel['sel'];
      }
      if($select == 1){
        $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','烘焙')
        ->order('c.create_time', 'desc')->paginate(20);
        $page = $fenLei->render();
        $this->assign('fenLei', $fenLei);
        $this->assign('page', $page);

      }elseif($select == 2){
       $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','烘焙')
       ->order('c.hits', 'desc')->paginate(20);

       $page = $fenLei->render();
       $this->assign('fenLei', $fenLei);
       $this->assign('page', $page);

     }else{


      $fenLei =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->where('small_name','烘焙')->paginate(20);

      $page = $fenLei->render();
      $this->assign('fenLei', $fenLei);
      $this->assign('page', $page);

    }
       
       return $this->fetch();
    }
     

}
