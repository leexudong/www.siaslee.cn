<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use app\index\model\Cateblock;
use app\index\model\Topiccomment as topcomment;
use app\index\model\User;
use app\index\model\Topic;
use think\Request;
use think\Db;
class TopicComment extends Auth
{
	
	
	public function topicComment()
	{
	     //根据上一个页面传过来的tid从数据库提取该话题的相关数据
	    $request = Request::instance();
	    $ids = $request->only('tid');
	    $id = $ids['tid'] *1;
	   	
	    //话题内容
	    $topic = new Topic;
	    $h = $topic->where('id',$id)->find();
	    $hits = $h['hits'];
	    //更新该话题点击量
	    $topic->save(['hits'=>$hits+1],['id'=>$id]);
	    $list = $topic->where('id',$id)->select();

	    //该话题的评论
	    $topiccomment = new topcomment;
	    $commentList = $topiccomment->where('topic_id',$id)->paginate(3);
	    $commentListPage = $commentList->render();
	   
	   $user ='';
	   //此时登录者的信息
	   if(empty(Session::get('uid'))){
	   	
	   		$this->assign('user',$user);
	   }
	  
	   $id = Session::get('uid');
	   $user = User::where('id',$id)->find();
	   //dump($user['photo']);
	   $this->assign('user',$user);
	    $this->assign('list',$list);
	    $i = 0; //用来在前台判断沙发板凳
	    $this->assign('i',$i);
	    $this->assign('commentList',$commentList);
	    $this->assign('commentListPage',$commentListPage);
	    
		return $this->fetch();
	}
	
	public function add()
	{
		if(empty(Session::get('uid'))){
			$this->error('您还未登录','__SITE__/index/auth/login');
		}
		
		$loginUserId = Session::get('uid');
		$request = Request::instance();
		$tids = $request->only('tid');
		$tid = $tids['tid']*1;
		$content = $_REQUEST['_content'];
		if(empty($content)){
			return $this->error('评论内容不可为空，请返回重新评论');
			
		}else{

			$comment = new topcomment;
			$result = $comment->data([
					'users_id'=>$loginUserId,
					'topic_id'=>$tid,
					'content'=>$content,
				])->save();
			if($result){
				$topic = new Topic;
			    $h = $topic->where('id',$tid)->find();
			    $hits = $h['hits'];
			    $comment_num = $h['comment_num'];
			    //更新该话题点击量  评论量
			    $topic->save([
			    	'hits'=>$hits+1,
			    	'comment_num'=>$comment_num+1
			    	],['id'=>$tid]);
				
				return $this->success('评论成功');
			}else{
				return $this->error('评论失败');
			}
		}
		
	}
}

