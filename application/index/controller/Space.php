<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\index\model\Cateblock;
use app\index\model\User;
use app\index\model\Cate;
use app\index\model\Collect;
class Space extends Auth
{
    
   
    public function space()
    {
       $request = Request::instance();
       $param = $request->param();
       $user_id = $param['user_id'];
       $userInfo = $this->user->userInfo('id',"$user_id");
       
       $cate =  Db::name('cate')->where('user_id','=',"$user_id")->paginate(6);
       $page = $cate->render();
       $this->assign('userInfo', $userInfo);
       $this->assign('cate', $cate);
       $this->assign('page', $page);
       //dump($cate);die();
       return $this->fetch();
    }
     public function personInfo()
    {
      $userInfo = $this->user->userInfo('id', "$this->uid");
      //dump($userInfo);
      $this->assign('userInfo', $userInfo);
       return $this->fetch();
    }


    public function setHead()
    {
       
      
       return $this->fetch();
    }

    public function collect()
    {
       $request = Request::instance();
       $param = $request->param();
       $user_id = $param['user_id'];
       $userInfo = $this->user->userInfo('id',"$user_id");
       $this->assign('userInfo', $userInfo);

       $cateId = $this->collect->shouSel('user_id', "$user_id");
       //dump($cateId);die();
       
       if($cateId){
        foreach($cateId as $id){
          $ids[] = $id['cate_id'];
          $cid[] = $id['id'];
        }
         $list = Cate::all($ids);
          $this->assign('cid', $cid);
        
       }else{
        $list = [];
       }
        //dump($list);
       //dump($cid);
       // die();
       
       $this->assign('list',  $list);

       

      
       return $this->fetch();
    }


     public function doCollect()
    {
      
          $user_id = $_REQUEST['user_id'];
          $cate_id = $_REQUEST['cate_id'];
         
          $collect = $this->collect->shouSel('user_id', "$user_id");
          //dump($collect);die();
          if(empty($collect)){
               $data = [
                   'user_id' => "$user_id",
                   'cate_id' => "$cate_id",
                  
                   ];
                   $result = $this->collect->shou($data);


                   if($result){
                    echo json_encode(['status' => 1, 'msg' => '已收藏', 'data' => '']);die();
                   }

          }else{

                   foreach ($collect as  $value) {
                    $allId[] = $value['cate_id'];
                  }

                 // dump($allId);die;
                  if(in_array($cate_id, $allId)){
                   echo json_encode(['status' => 0, 'msg' => '已收藏', 'data' => '']);die();
                 }else{

                   $data = [
                   'user_id' => "$user_id",
                   'cate_id' => "$cate_id"
                   ];
                   $result = $this->collect->shou($data);


                   if($result){
                    echo json_encode(['status' => 1, 'msg' => '已收藏', 'data' => '']);die();
                  }

                }


          }
     
    }

    //取消收藏
    public function cancle()
    {
      $request = Request::instance();
      $param = $request->param();
      //$cate_id = $param['cate_id'];
      $id = $param['collect_id'];
      //dump($param);die();
      $cancle = Db::name('collect')->where('id',"$id")->delete();
      if($cancle){
        $this->success('取消成功');
      }else{
         $this->error('取消成功');
      }
    }


     public function head()
    {
        if(request()->file('photo')){
        
          // 获取表单上传文件 例如上传了001.jpg
          $file = request()->file("photo");
          // 移动到框架应用根目录/public/uploads/ 目录下
          $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
          if($info){
         
          // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
          $path = $info->getSaveName();
          
          }else{
          // 上传失败获取错误信息
          echo $file->getError();
          }
          $photo = '__SITE__/'.'uploads/'.str_replace('\\', '/',$path);



      }else{
          $this->error('你没有选择要上传的头像');
      }
      
      
       $data = [
          'photo' =>"$photo",
      ];
      $if =[
        'id' =>"$this->uid",

      ];
     
      $result = $this->user->updateHead($data,$if);
      
      if($result){
        Session::set('photo',"");
        Session::set('photo',"$photo");
        $this->success('头像设置成功');
      }else{
        $this->error('头像设置失败');
      }

     }

    public function setPsw()
    {

       return $this->fetch();
    }
    public function pwd()
    {
  
             $result =  $this->user->loginSel('id',"$this->uid");
             $old_password = $result->password;
             if($old_password == md5($_REQUEST['old_password'])){
                  if($_REQUEST['new_password']){
                      if($_REQUEST['new_password'] == $_REQUEST['re_password']){
                        $password = md5($_REQUEST['new_password']);
                          $data = [
                            'password' =>"$password",

                          ];
                          $if = [
                              'id' => "$this->uid",
                          ];
                         $result =  $this->user->updateInfo($data, $if);
                         if($result){
                          $this->success('密码修改成功');
                         }else{
                          $this->error('密码修改失败');
                         }

                      }else{
                        $this->error('两次密码输入不一致');
                      }
                  }else{
                    $this->error('新密码不能为空');
                  }
             }else{
              $this->error('原始密码输入错误');
             }
    }


    public function setInfo()
    {

          $uid= Session::get('uid');
           
          $email = $_REQUEST['email'];
          $phone = $_REQUEST['phone'];
          $username = $_REQUEST['username'];
          $sex = $_REQUEST['sex'];
          $home = $_REQUEST['home'];
          $address = $_REQUEST['address'];
          $signature = $_REQUEST['signature'];
          $code = $_REQUEST['code'];
          $birthday = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
          if(captcha_check($code)){
              $data = [
              'id' =>"$uid",
              'email' => "$email",
              'phone' => "$phone",
              'username' => "$username",
              'sex' =>"$sex",
              'home' =>"$home",
              'birthday'=>"$birthday",
              'address' =>"$address",
              'signature' =>"$signature",

              ];
              $result = $this->user->updateInfo($data,$uid);
              if($result){
                    $this->success('个人资料修改成功');
                 // echo json_encode(['status' => 1, 'msg' => '个人资料修改成功', 'data' => '']);die();
              }else{
                    $this->error('个人资料修改失败');
                  //echo json_encode(['status' => 0, 'msg' => '个人资料修改失败', 'data' => '']);die();
              }
          }else{
              $this->error('验证码错误');
          //echo json_encode(['status' => 0, 'msg' => '验证码错误', 'data' => '']);die();
          }
    }


    public function email()
    {
          $subject="测试";

          $email=$_REQUEST['email'];
       
          $con = '<style class="fox_global_style"> div.fox_html_content { line-height: 1.5;} /* 一些默认样式 */ blockquote { margin-Top: 0px; margin-Bottom: 0px; margin-Left: 0.5em } ol, ul { margin-Top: 0px; margin-Bottom: 0px; list-style-position: inside; } p { margin-Top: 0px; margin-Bottom: 0px } </style><table style="-webkit-font-smoothing: antialiased;font-family:"微软雅黑", "Helvetica Neue", sans-serif, SimHei;padding:35px 50px;margin: 25px auto; background:rgb(247,246, 242); border-radius:5px" border="0" cellspacing="0" cellpadding="0" width="640" align="center"> <tbody> <tr> <td style="color:#000;"> </td> </tr> <tr><td style="padding:0 20px"><hr style="border:none;border-top:1px solid #ccc;"></td></tr> <tr> <td style="padding: 20px 20px 20px 20px;"> Hi 你好 </td> </tr> <tr> <td valign="middle" style="line-height:24px;padding: 15px 20px;"> 感谢您注册phpbryant <br> 请点击以下链接修改您的密码： </td> </tr> <tr> <td style="height: 50px;color: white;" valign="middle"> <div style="padding:10px 20px;border-radius:5px;background: rgb(64, 69, 77);margin-left:20px;margin-right:20px"> <a style="word-break:break-all;line-height:23px;color:white;font-size:15px;text-decoration:none;" href="http://wwwphpbryant.com">http://wwwphpbryant.com</a> </div> </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> 请勿回复此邮件，如果有疑问，请联系我们：<a style="color:#5083c0;text-decoration:none" href="mailto:liuhao@phpbryant.com">liuhao@phpbryant.com
        </a> </td> </tr><tr> <td style="padding: 20px 20px 20px 20px"> 交流群：000000 </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> - phpbryant 团队-帮助你更快的完成项目- phpbryant.com </td> </tr> </tbody> </table>';
        $status = send($email,$subject,$con);
        if($status){
          echo 'success';
        }else{
          echo 'error';
        }
    }
   

   

}
