<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use app\index\model\Cateblock;
use app\index\model\Topic as top;
use app\index\model\User;
use app\index\model\Topicblock;
use think\Db;
class Topic extends Auth
{
  

  public function topic()
  {  
      
     //topic数据信息
     $topic = new top;
     $list = $topic->where('id','>',0)->order('hits','desc')->paginate(5);
      $page = $list->render();
      $this->assign('list',$list);
      $this->assign('page',$page);

     //话题板块
     $topicBlock = new Topicblock;
     $topicBlocklist = $topicBlock->where('id','>',0)->select();
     $this->assign('topicBlocklist',$topicBlocklist);
     
     //积分达人
     $userlist = User::where('delete_time',null)->limit(10)->order('score','desc')->select();
     $i=1;
     $this->assign('i',$i);
     $this->assign('userlist',$userlist);

     //发帖达人
      //本日
      $year = date("Y");
      $month = date("m");
      $day = date("d");
      $start1 = mktime(0,0,0,$month,$day,$year);//当天开始时间戳 1481299200
      $end1= mktime(23,59,59,$month,$day,$year);//当天结束时间戳 1481385599
     $darenDay = $this->daren($end1,$start1);
      $this->assign('darenDay',$darenDay);
      //本周
      $week = date("w");
      $weekFirstDay = $day-$week+1;
      $weekEndDay = $day+(7-$week);
      $start2 = mktime(0,0,0,$month,$weekFirstDay,$year);//本周开始时间戳 
      $end2 = mktime(23,59,59,$month,$weekEndDay,$year);//本周结束时间戳 
     $darenWeek = $this->daren($end2,$start2);
     $this->assign('darenWeek',$darenWeek);
      //本月
      if(($year%4==0 && $year%100!=0) || $year%400==0){
        //闰年
        switch ($month) {
        case '2':
          $days = 29;
          break;
        case '1':
        case '3':
        case '5':
        case '7':
        case '8':
        case '10':
        case '12':
       
          $days = 31;
          break;
        default:
          $days=30;
          break;
        }

      }else{
        //平年
        switch ($month) {
        case '2':
          $days = 28;
          break;
        case '1':
        case '3':
        case '5':
        case '7':
        case '8':
        case '10':
        case '12':
          $days = 31;
          break;
        default:
          $days=30;
          break;
        }
      }
    $monthFirstDay = 1; 
    $monthEndDay = $days;
    $start3 = mktime(0,0,0,$month,$monthFirstDay,$year);//本月开始时间戳 
    $end3 = mktime(23,59,59,$month,$monthEndDay,$year);//本月结束时间戳 
    $darenMonth = $this->daren($end3,$start3);
    $this->assign('darenMonth',$darenMonth);
    return $this->fetch('topic');
  }
  

  //发布话题
  public function publishTopic()
  {
  
   if(empty(Session::get('uid'))){

      $this->error('您尚未登录','__SITE__/index/auth/login');
     
    }

    
      return $this->fetch('publishtopic');
  }
 
  //处理发布的话题到数据库
  public function doPublishTopic()
  { 
           $topicBlock_id = $_REQUEST['topicBlock_id'] *1;
           $title = $_REQUEST['title'];
           $content = $_REQUEST['content'];
           if($title==null){
            return $this->error('标题不得为空，请您重新编辑');
           }
           if($content==null){
              return $this->error('话题内容不得为空，请您重新编辑');
           }
           
              $uid = Session::get('uid')*1;
              $user = User::where('id',$uid)->find();
              $score = $user->score;
              $topicNum = $user->topic_num;
              //dump($score);
              $topic = new top;
              $result = $topic->data([
                  'user_id' =>$uid,
                  'topicblock_id'=>$topicBlock_id,
                  'title'=>$title,
                  'content'=>$content,
                  //'topic_pic'=>$path,
                ])->save();
              if($result){
                $result2 = User::update(['id' => $uid,'topic_num'=>($topicNum+1), 'score' => ($score+100)]); 
                  if($result2){
                    $this->success("恭喜您发布话题成功,积分增加100","__SITE__/index/topic/topic");
                  }else{
                    $this->error('积分未增加成功');
                  }
                
              }else{
                $this->error('发布话题失败');
              }
  }
  //餐桌时光  
  /*public function tableTime()
  { 
     //头部信息数据
      //$this->header();

      //调用detai方法获取模板文件需要的数据
      $this->detail();
      return $this->fetch('tableTime');
  }
*/
  //玩转烘焙  
  public function palyBake()
  {
    //头部信息数据
      //$this->header();


    
      //调用detai方法获取模板文件需要的数据
       $this->detail();
       return $this->fetch('palyBake');
  }
  
  //美食课堂
  public function cateClass()
  {
    //头部信息数据
      //$this->header();



      //调用detai方法获取模板文件需要的数据
       $this->detail();
       return $this->fetch('cateClass');
  }

  public function detail()
  {
      
      //得到该板块id
       $request = Request::instance();
       $param = $request->only(['topicblock']) ;
       $topicblock = $param['topicblock'] *1;
      //该板块下的话题分页显示
      $tableTopic = new top;
      $tableTopicList = $tableTopic->where('topicblock_id',$topicblock)->order('create_time','desc')->limit(5)->paginate(5); 
      
      $page = $tableTopicList->render();
      $this->assign('tableTopicList',$tableTopicList);
      $this->assign('page',$page);
      //dump($tableTopicList);
      //该板块下的热门话题
      $hitList = $tableTopic->where('topicblock_id',$topicblock)->order('hits','desc')->limit(5)->select();
     $this->assign('hitList',$hitList);
     
     //本版今日发帖达人
     $year = date("Y");
      $month = date("m");
      $day = date("d");
      $start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
      $end= mktime(23,59,59,$month,$day,$year);//当天结束时间戳

      $users =  Db::query("SELECT user_id, COUNT(title) AS count FROM `g_topic` WHERE create_time <=$end AND create_time>=$start AND topicBlock_id=$topicblock GROUP BY user_id");//users是个二维数组
     if($users){
          //遍历users这个二维数组，并把user_id和发帖总数count分别存到不同数组
          foreach ($users as  $value) {
            $counts[] = $value['count'];
            $id[] = $value['user_id'];
          }
         
          $maxcount = max($counts); //得到该达人今日的发帖总数
          $length = count($counts); //得到数组的长度（两个数组长度一样）
          for($i=0;$i<$length;$i++){
            if($maxcount==$counts[$i]){
              $ii = $i;  //得到对应键值
            }
          }
          $user_id = $id[$ii]; //根据上面键值得到该达人的id
          $user = User::where('id',$user_id)->find();
          $hotusername = $user['username'];
          $hotuserphoto = $user['photo'];
          $this->assign('hotusername',$hotusername);
          $this->assign('userid',$user_id);
          $this->assign('hotuserphoto',$hotuserphoto);
          $this->assign('maxcount',$maxcount);
      }
     $this->assign('users',$users);
    }

    public function daren($end,$start)
    {
      
      $user = Db::query("SELECT user_id, COUNT(title) AS coun FROM g_topic WHERE create_time <=$end AND create_time>=$start AND delete_time is null GROUP BY user_id ORDER BY coun DESC LIMIT 0,5"); //二维数组
     
      $daren = [];
   
      $users = new User;
      if($user){
          //遍历users这个二维数组
          foreach ($user as  $value) {
            $id= $value['user_id'];
             $u= $users->where('id',$id)->find();
             $daren[$id]['id']=$id;
             $daren[$id]['photo'] = $u['photo'];
             $daren[$id]['username'] = $u['username'];
            $daren[$id]['count'] = $value['coun'];

          }
         //dump($daren);
         return $daren;
        }
        return $daren;

    }

    //搜索
    public function search()
    {
    
      $words  = $_POST['words'];
      $topic = new top;
     
     $list =  $topic->where('title','like',"%$words%")->paginate(10);
     //$page = $list->render();
    
     $this->assign('words',$words);
     $this->assign('list',$list);
     //$this->assign('page',$page);
     return $this->fetch();
    }

    //某用户所有的帖子
    public function allTopic()
    {
      $request = Request::instance();
      $uidArray = $request->only('uid');
      $uid = $uidArray['uid'] *1;
      $topic = new top;
      $list = $topic->where('user_id',$uid)->select();
      $this->assign('list',$list);
      return $this->fetch();
    }

}
