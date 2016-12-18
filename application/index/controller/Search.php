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
class Search extends Auth
{
    
    public function search()
    {
      $search = $_REQUEST['search'];
  //$cateList =  Db::name('user')->alias('u')->join('g_cate c','u.id = c.user_id')->select();
      $sear = Db::name('user')->alias('u')->join('g_cate c', 'u.id = c.user_id')
      ->where('username|cate_title','like','%'."$search")->select();
      $this->assign('sear', $sear);
//dump($sear);
       return $this->fetch();
    }
    
     

}
