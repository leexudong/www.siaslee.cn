<?php
namespace app\admin\controller;
use app\admin\model\Goods as goo;
use think\Controller;
use think\Db;
use think\Request;
class Goods extends Controller
{
	public function add()
	{
		// 获取表单上传图片文件
		$files = request()->file('image');
		if(empty($files)){
			$this->error('请务必上传够5张图片');
		}
		foreach($files as $file){
			// 移动到框架应用根目录/public/uploads/ 目录下
			$info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
		if($info){
		
			$path = $info->getSaveName();
			//dump($path);
			$p = str_replace('\\','/',$path);
			$paths[] = 'http://www.siaslee.cn/'.'uploads/'.$p;

		}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}

		$goodsName = $_REQUEST['goodsName'];
		$goodsPrice = $_REQUEST['goodsPrice'];
		$totalNum = $_REQUEST['totalNum'];
		$goodsBlock = $_REQUEST['goodsBlock'] *1;
		//dump($goodsBlock);
		$goods = new goo;

		$length = count($paths);
		if($length==5){
			$result = $goods ->data([
				'goods_name'=>$goodsName,
				'price'=>$goodsPrice,
				'total_num'=>$totalNum,
				'detail_pic'=>$paths[0],
				'goodsblock_id'=>$goodsBlock,
				'show1'=>$paths[1],
				'show2'=>$paths[2],
				'show3'=>$paths[3],
				'show4'=>$paths[4],
			])->save();
		}elseif($length==4){
			$result = $goods ->data([
			'goods_name'=>$goodsName,
				'price'=>$goodsPrice,
				'total_num'=>$totalNum,
				'detail_pic'=>$paths[0],
				'goodsblock_id'=>$goodsBlock,
				'show1'=>$paths[1],
				'show2'=>$paths[2],
				'show3'=>$paths[3],
				])->save();
		}elseif($length==3){
			$result = $goods ->data([
				'goods_name'=>$goodsName,
				'price'=>$goodsPrice,
				'total_num'=>$totalNum,
				'goodsblock_id'=>$goodsBlock,
				'detail_pic'=>$paths[0],
				'show1'=>$paths[1],
				'show2'=>$paths[2],
				])->save();
		}elseif($length==2){
			$result = $goods ->data([
				'goods_name'=>$goodsName,
				'price'=>$goodsPrice,
				'total_num'=>$totalNum,
				'goodsblock_id'=>$goodsBlock,
				'detail_pic'=>$paths[0],
				'show1'=>$paths[1],
				])->save();
		}else{
			$result = $goods ->data([
			'goods_name'=>$goodsName,
				'price'=>$goodsPrice,
				'total_num'=>$totalNum,
				'goodsblock_id'=>$goodsBlock,
				'detail_pic'=>$paths[0],
				])->save();
		}
		
		
		 
		if($result){
			$this->success('添加商品：'.$goodsName.' 成功');
		}else{
			$this->false('添加商品失败');
		}
	}

	//下架商品
	public function del()
	{
		$id = $_REQUEST['gid'];
		$goods = new goo;
		$result = $goods->destroy($id);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'商品下架成功']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'商品下架失败']);
			die();
		}
	}

	//上架
	public function move()
	{
		$request = Request::instance();
		$id = $request->only(['id']);
		$ids = $id['id'] *1;
		
		
		$result = Db::table('g_goods')->where('id',$ids)->update(['delete_time'=>null]);
		if($result){
			echo json_encode(['status'=>1,'msg'=>'renew success']);
			die();
		}else{
			echo json_encode(['status'=>0,'msg'=>'renew false']);
			die();
		}
	}


	public function set()
	{
		$ids = $_REQUEST['gidarray'];
		$goods = new goo;
		foreach ($ids as $id) {
			$goodsPrice = $_REQUEST['goodsPrice'][$id];
			$soldNum = $_REQUEST['soldNum'][$id];
			$totalNum = $_REQUEST['totalNum'][$id];

			$result = $goods ->save([

					'price' =>$goodsPrice,
					'sold_num' =>$soldNum,
					'total_num'=>$totalNum,
				],['id'=>$id]);

		}
		if($result){
			$this->success('修改商品信息成功');
		}else{
			$this->false('修改商品信息失败');
		}
	}


}
