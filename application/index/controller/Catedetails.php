<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\index\model\Cate;
use app\index\model\Cateblock;
use app\index\model\Meterials;
use app\index\model\User;
use app\index\model\Catecomment;
class Catedetails extends Auth
{
   
    public function Catedetails()
    {

     $request = Request::instance();
     $param = $request->param();
     $cate_id = $param['cate_id'];
     $user_id = $param['user_id'];
     $uid = Session::get('uid');
     $this->assign('uid', $uid);
     //用信息查询
     $userInfo = $this->user->userInfo('id', "$user_id");
     $this->assign('userInfo', $userInfo);
     //对应cate_id 的菜谱信息查询
     $cateInfo = $this->cate->cateSel('id', "$cate_id");
     //dump($cateInfo);
     $this->assign('cateInfo', $cateInfo);

    //查询材料表的信息
     $zlInfo =  Db::name('meterials')->where('cate_id','=',"$cate_id")->where('type',1)->select();
     $flInfo =  Db::name('meterials')->where('cate_id','=',"$cate_id")->where('type',0)->select();
     //dump($zlInfo);dump($flInfo);
     $this->assign('zlInfo', $zlInfo);
     $this->assign('flInfo', $flInfo);
     //查询步骤信息
      $step =  Db::name('step')->where('cate_id','=',"$cate_id")->order('id asc')->select();
      $this->assign('step', $step);
      //查询评论
        
        $comment =  Db::name('user')->alias('u')->join('g_catecomment c','u.id = c.user_id')->where('cate_id',"$cate_id")->order('c.create_time desc')->paginate(10);
      // dump($comment);
       $page = $comment->render();
       $this->assign('comment', $comment);
        $this->assign('page', $page);
         $look =  Db::name('cate')->where('id', $cate_id)->setInc('hits', 1);
      return $this->fetch();
    }
    public function comment()
    {
       if(empty($this->uid)){
        $this->error('请先登陆', 'Auth/login');
       }
       
        $content = $_REQUEST['comment'];
        $cate_id = $_REQUEST['cate_id'];
        $user_id = $this->uid;
        $comment = [
            'user_id' => "$user_id",
            'cate_id' => "$cate_id",
            'content' => "$content",

        ];
        //往数据库插入评论数据
        $result = $this->catecomment->docomment($comment);

        if($result){
            $score =  Db::name('user')->where('id', $this->uid)->setInc('score', 10);
            $comment_num =  Db::name('cate')->where('id', $cate_id)->setInc('comment_num', 1);
            $this->success('评论成功, 积分 +10');
        }else{
            $this->error('评论失败');
        }

    }

    public function delcomment()
    {
        $request = Request::instance();
        $param = $request->param();
        $comment_id = $param['comment_id'];
        $cate_id = $param['cate_id'];
        //用户删除自己的评论
        $del = Db::name('catecomment')->where('id',"$comment_id")->delete();
       
        if($del){
            $comment_num =  Db::name('cate')->where('id', $cate_id)->setDec('comment_num', 1);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }

    }

       

}