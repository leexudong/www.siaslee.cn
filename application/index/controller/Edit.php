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
class Edit extends Auth
{
    
    public function edit()
    {
      $request = Request::instance();
      $param = $request->param();
      $cate_id = $param['cate_id'];
      //查询菜谱表内容
      $cate = Db::name('cate')->where('id',"$cate_id")->find();
      //查询步骤表内容
      $step = Db::name('step')->where('cate_id',"$cate_id")->select();
      //查询材料表中的主料
      $zhuliao  = Db::name('meterials')->where('cate_id',"$cate_id")->where('type','1')->select();
      //查询材料表中的辅料
      $fuliao =  Db::name('meterials')->where('cate_id',"$cate_id")->where('type','0')->select();
      //dump($step);die;
      $this->assign('cate', $cate);
      $this->assign('step', $step);
      $this->assign('zhuliao', $zhuliao);
      $this->assign('fuliao', $fuliao);
     
     
      return $this->fetch();
    }


     public function update()
    {
      $request = Request::instance();
      $param = $request->param();
      $cate_id = $param['cate_id'];


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

          'difficulty' => "$difficulty",
          'ready_time' => "$ready_time",
          'cook_time' => "$cook_time",
          'person_num' => "$person_num",
          'final_pic' => "$final_pic",
          'story' => "$story"

       ];
      $if = [
          'id' => "$cate_id" 
      ];
       $result1 = $this->cate->doEdit($data1,$if);
       
       




       $zlname = $_REQUEST['zlsc'];
       $zlyl = $_REQUEST['zlyl'];
       $flname = $_REQUEST['flsc'];
       $flyl = $_REQUEST['flyl'];
      
      $zhuLiao = array_combine($zlname, $zlyl);
      $fuLiao = array_combine($flname, $flyl);
      $length1 = count($zhuLiao);
      $length2 = count($fuLiao);

  
        foreach ($zhuLiao as $key=> $value) {
            if(!empty($value)){
              // echo $value;
              // echo $key;
              $data2 = [
              
              'name' =>  "$key",
              'dose' =>  "$value",
             
                  
                   'update_time' => time(),

              ];
              $if2 = [
                  'cate_id' => "$cate_id",
                   'type'  =>  '1'

              ];
             
              //$result2 = $this->meterials->addMeterials($data2);
             // Db::table('think_user')->where('id', 1)->update($data2);
               $result2 = $this->meterials->zlEdit($data2,$if2);
              // dump($result2);die();
            }
      
      }
    
   


   
          foreach ($fuLiao as $key=> $value) {
              if(!empty($value)){
           
              
               $data3 = [
               
               'name' =>  "$key",
               'dose' =>  "$value",
               'update_time' => time(),

               ];

                $if3 = [
                  'cate_id' => "$cate_id",
                   'type'  =>  '0'

              ];
               //$result3 =  Db::name('meterials')->insert($data3);
                $result3 = $this->meterials->flEdit($data3,$if3);
                // dump($result3);die();
             }
          
          }

    
 
  


       $step = $_REQUEST['step_text'];
       $skill = $_REQUEST['skill'];
    
       
   
        foreach ($step as  $value) {
          if(!empty($value)){
               $data4 = [
               
                'description' =>  "$value",
                'cate_skill' =>  "$skill",
                
                
                 'update_time' => time(),
                      
                ];
                $if4 = [
                    'cate_id' => "$cate_id",
                ];
                //$result4 = Db::name('step')->insert($data4);
                $result4= $this->step->stepEdit($data4,$if4);
               
          }
       }
 //dump($result1); dump($result2); dump($result3); dump($result4);die();

     

    
         

       if($result1 || $result2 || $result3 || $result4){
        $this->success('更新菜谱成功');


      }else{
        $this->success('更新菜谱失败，请重新更新');
      }
    }
   
    

}