<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use app\index\model\Cateblock;
use app\index\model\User;
use app\index\model\Cate;
class Score extends Auth
{
   
   
     public function score()
    {
       if(empty($this->uid)){
       	$this->error('请先登录','Auth/login');
       }
     
       return $this->fetch();
    }

    public function rank()
    {
       
       return $this->fetch();
    }

  


}
