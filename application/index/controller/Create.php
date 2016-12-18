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
class Create extends Auth
{
    
    public function create()
    {
      if(empty($this->uid)){
        $this->error('请先登录', 'Auth/login');
      }
     
      return $this->fetch();
    }

     public function upload()
    {
      if(request()->file('image')){
     
       // 获取表单上传文件 例如上传了001.jpg
          $file = request()->file("image");
          // 移动到框架应用根目录/public/uploads/ 目录下
          $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
          if($info){
         
          // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
          $path = $info->getSaveName();
          
          }else{
          // 上传失败获取错误信息
          echo $file->getError();
          }
          $final_pic = '__SITE__/'.'uploads/'.str_replace('\\', '/',$path);



      }else{
          $this->error('请上传成品图');
      }
      

    
       $user_id =  Session::get('uid');
        $username = Session::get('username');
       $title = $_REQUEST['title'];
       $big_name = $_REQUEST['s_province']; 
       $small_name = $_REQUEST['s_city'];

       $difficulty = $_REQUEST['leval'];
       $ready_time = $_REQUEST['readytime'];
       $cook_time = $_REQUEST['cooktime'];
       $person_num = $_REQUEST['eatnum'];
       $story = $_REQUEST['story'];

      
       $data1 =[
          'user_id' => "$user_id",
          'cate_title' => "$title",
          'big_name' => "$big_name",
          'small_name' => "$small_name",
          'author' =>"$username",
          'difficulty' => "$difficulty",
          'ready_time' => "$ready_time",
          'cook_time' => "$cook_time",
          'person_num' => "$person_num",
          'final_pic' => "$final_pic",
          'story' => "$story"

       ];
      
       $result1 = $this->cate->postcate($data1);
       $cate_id = $this->cate->id;
      




       $zlname = $_REQUEST['zlsc'];
       $zlyl = $_REQUEST['zlyl'];
       $flname = $_REQUEST['flsc'];
       $flyl = $_REQUEST['flyl'];
      
      $zhuLiao = array_combine($zlname, $zlyl);
      $fuLiao = array_combine($flname, $flyl);
      $length1 = count($zhuLiao);
      $length2 = count($fuLiao);

    if($length1-1){
        foreach ($zhuLiao as $key=> $value) {
            if(!empty($value)){
              // echo $value;
              // echo $key;
              $data2 = [
              'cate_id' =>  "$cate_id",
              'name' =>  "$key",
              'dose' =>  "$value",
              'type' =>  "1",
                   'create_time' => time(),
                   'update_time' => time(),

              ];
             
              //$result2 = $this->meterials->addMeterials($data2);
              $result2 =  Db::name('meterials')->insert($data2);

            }
      
      }
    }else{
      $this->error('请填写主料');
    }

   


    if($length2-1){
          foreach ($fuLiao as $key=> $value) {
              if(!empty($value)){
           
              
               $data3 = [
               'cate_id' =>  "$cate_id",
               'name' =>  "$key",
               'dose' =>  "$value",
               'type' =>  "0",
               'create_time' => time(),
               'update_time' => time(),

               ];
               $result3 =  Db::name('meterials')->insert($data3);
             }
          
          }

    }else{
        $this->error('请填写辅料');

    }
    
 
  


       $step = $_REQUEST['step_text'];
       $skill = $_REQUEST['skill'];
    
        $num = 0;
   for($i = 0; $i<count($step); $i++){
    if(empty($step[$i])){
      $num++;
    }
   }
   if($num == count($step)){
    $this->error('请上传步骤');
   }else{
        foreach ($step as  $value) {
          if(!empty($value)){
               $data4 = [
                'cate_id' =>  "$cate_id",
                'description' =>  "$value",
                'cate_skill' =>  "$skill",
                
                 'create_time' => time(),
                 'update_time' => time(),
                      
                ];
                $result4 = Db::name('step')->insert($data4);
          }
       }


   }
      
     

      if($result1 && $result2 && $result3 && $result4){
          $score = [
              'score' => "score + 200",

          ];

          $if = [
              'id' => "$user_id",

          ];

         $result =  Db::table('g_user')->where('id', $this->uid)->setInc('score', 200);
          $num =  Db::table('g_user')->where('id', $this->uid)->setInc('cate_num', 1);

          if($result && $num){

            $this->success('发布菜谱成功  +200积分');

          }
      }else{
            $this->success('发布菜谱失败，请重新发布');
      }
    }
    

}