<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Controller;
use think\Session;
use think\Request;
use app\index\model\Goods as goo;
use app\index\model\Goodsblock;
use app\index\model\Cateblock;
use app\index\model\User;
use app\index\model\Order;
use think\Db;
class  Goods extends Auth
{
	
	public function goods()
	{	

		$goods = new goo;
		$goodsblock = new Goodsblock;
		//2个样品商品
		$twoList = $goods->where('id','>',0)->limit(2)->select();
		$this->assign('twoList',$twoList);

		//厨房家居下的小分类
		$kitchenList = $goodsblock->where('pid',1)->select();;
		$this->assign('kitchenList',$kitchenList);
		
			//厨房家居下默认的小分类
		$defaultList = $goods->where('goodsblock_id',5)->limit(8)->select();
		$this->assign('defaultList',$defaultList);

		//厨房电器下的小分类
		$electricalList = $goodsblock->where('pid',2)->select();;
		$this->assign('electricalList',$electricalList);

			//厨房电器下默认的小分类
		$defaultList2 = $goods->where('goodsblock_id',10)->limit(8)->select();
		$this->assign('defaultList2',$defaultList2);

		//厨房调料下的小分类
		$flavourList = $goodsblock->where('pid',3)->select();;
		$this->assign('flavourList',$flavourList);
		
			//厨房调料下的默认分类
		$defaultList3 = $goods->where('goodsblock_id',12)->limit(8)->select();
		$this->assign('defaultList3',$defaultList3);
		

		return $this->fetch();
	}

	public function detailGoods()
	{
		$request = Request::instance();
		$gids = $request->only('gid') ;
		$gid = $gids['gid'] *1;

		//当前这个商品的详细信息
		$goods = new goo;
		$thisGoods = $goods ->where('id',$gid)->find();
		
		$goodsName = $thisGoods['goods_name'];
		$price = $thisGoods['price'];
		$sold_num = $thisGoods['sold_num'];
		$stock = $thisGoods['total_num']-$thisGoods['sold_num'];
		$show1 = $thisGoods['show1'];
		$show2 = $thisGoods['show2'];
		$show3 = $thisGoods['show3'];
		$show4 = $thisGoods['show4'];
		$detail_pic = $thisGoods['detail_pic'];
		$this->assign('goodsName',$goodsName);
		$this->assign('goodsId',$gid);
		$this->assign('stock',$stock);
		$this->assign('price',$price);
		$this->assign('show1',$show1);
		$this->assign('show2',$show2);
		$this->assign('show3',$show3);
		$this->assign('show4',$show4);
		$this->assign('sold_num',$sold_num);
		$this->assign('detail_pic',$detail_pic);

		//推荐两个商品
		$twoList = $goods->where('id','<>',$gid)->order('sold_num','desc')->limit(2)->select();
		$this->assign('twoList',$twoList);

		//蚂蚁线
		$smallBlock_id = $thisGoods['goodsblock_id'];
		$this->assign('tid',$smallBlock_id);

		//推荐两个商品
		$twoList = $goods->where('goodsblock_id',$smallBlock_id)->order('sold_num','desc')->limit(2)->select();
		$this->assign('twoList',$twoList);


		$goodsblock = new Goodsblock;
			//小板块名字
		$block = $goodsblock->where('id',$smallBlock_id)->find();
		$this->assign('smallBlock_name',$block['block_name']);
			//大板块名字
		$bigBlock_id = $block['pid'];
		$blockBig = $goodsblock->where('id',$bigBlock_id)->find();
		$this->assign('bigBlock_name',$blockBig['block_name']);

		return $this->fetch();
	}

	//选项卡变换图片ajax效果
	public function do()
	{
		$request = Request::instance();
		//$pids = $request->only(['pid']);
		//$pid = $pids['pid'] *1;
		$ids = $request->only(['id']);
		$id = $ids['id']*1;
		$shows = [];
		$idss = [];
		$goods = new goo;

		$listshow = $goods ->where('goodsblock_id',$id)->limit(7)->select();
		foreach ($listshow as  $value) {
			$idss[] = $value->id;
			$shows[] =$value->show1; 
		}

          return  " 
            <div class=jjg_foods_show_$id>
                <div class='showitems'>
	                <div class='jjg_foods_show_big'><a target='_blank' href='http://www.siaslee.cn/goods/detailGoods/gid/$idss[0]'>
	                <img src=$shows[0]></a></div>
	                <div class='jjg_foods_show_small '><a target='_blank' href='http://www.siaslee.cn/index/goods/detailGoods/gid/$idss[1]'><img src=$shows[1]></a></div>
	                <div class='jjg_foods_show_small '><a target='_blank' href='http://www.siaslee.cn/index/goods/detailGoods/gid/$idss[2]'><img src=$shows[2]></a></div>
	                <div class='jjg_foods_show_small '><a target='_blank' href='http://www.siaslee.cn/index/goods/detailGoods/gid/$idss[3]'><img src=$shows[3]></a></div>
	                <div class='jjg_foods_show_small '><a target='_blank' href='_http://www.siaslee.cn/index/goods/detailGoods/gid/$idss[4]'><img src=$shows[4]></a></div>
	                <div class='jjg_foods_show_small '><a target='_blank' href='http://www.siaslee.cn/index/goods/detailGoods/gid/$idss[5]'><img src=$shows[5]></a></div>
	                <div class='jjg_foods_show_small '><a target='_blank' href='http://www.siaslee.cn/index/goods/detailGoods/gid/$idss[6]'><img src=$shows[6]></a></div>
                </div>
            </div>
		 ";
		
	}


	//兑换商品
	public function buy()
	{
		
		if(empty(Session::get('uid'))){
			$this->error('请先登录','__SITE__/index/auth/login');
		}
		$request = Request::instance();
		$gids = $request->only('gid') ;
		$gid = $gids['gid'] *1;  //该商品id
		$amount = $_REQUEST['amount'] *1; //购买量
		if(!$amount){
			$this->error('请填写购买数量');
		}

		$uid = Session::get('uid');
		$userid = $uid *1;
		$user = new User;
		$thisUser = $user->where('id',$userid)->find();
		//dump($thisUser['score']);
		$request = Request::instance();
		$gids = $request->only('gid') ;
		$gid = $gids['gid'] *1;  //该商品id
		$amount = $_REQUEST['amount'] *1; //购买量

		$goods = new goo;
		$thisGoods = $goods->where('id',$gid)->find();
		$remainGoods = $thisGoods->total_num -($thisGoods->sold_num);
		if($remainGoods<$amount){
			$this->error('您的购买量已超出库存量');
		}
		if($thisUser['score']<($thisGoods['price'])*$amount){
			$this->error('您的积分不够');
		}
		$goods_name = $thisGoods->goods_name;  //商品名字
		
		//可以成功购买
		$remainScore = $thisUser['score']-($thisGoods['price']*$amount) +100;//购买之后的积分再奖励100分
		
		$oldGoodsNum = $thisGoods->sold_num;
		$spendScore = ($thisGoods['price']*$amount); 
		$shoppingAddress  =$thisUser['shopping_address'];
		$shoppingName  =$thisUser['shopping_name'];
		$shoppingPhone  =$thisUser['shopping_phone'];
		if(empty($shoppingAddress) || empty($shoppingName) || empty($shoppingPhone)){
			$this->error('请填写完整的收货信息之后再购买','__SITE__/index/goods/shoppingAddress');
		}
		//数据插入订单表
		$order = new Order;
		$result3 = $order->data([
				'user_id' => $userid,
				'goods_id' => $gid,
				'goods_num' =>$amount,
				'goods_name'=> $goods_name,
				'spend_score'=>$spendScore,
				'shopping_address'=>$shoppingAddress,
				'shopping_name'=>$shoppingName,
				'shopping_phone'=>$shoppingPhone,
			])->save();

		$result2 = $thisGoods->save([
			'sold_num' => $oldGoodsNum + $amount,
			],['id',$gid]);  //更新商品库的售出量
		$result1 = $thisUser->save([
				'score'=>$remainScore,
			],['id',$userid]);  //更新用户积分

		if($result3 && $result2 && $result1){
			$this->success('恭喜您购买成功');
		}else{
			$this->error('购买失败,请重新购买');
		}
		
	}

	//系列商品（例如锅具，茶具整个系列的商品）
	public function goodsType()
	{

		$request = Request::instance();
		$tidArray = $request->only('tid');
		$tid = $tidArray['tid'] *1;   //得到系列id即板块id
		$choiceArray = $request->only('choice');
		if($choiceArray==null){
			$choice = 0;
		}else{
			$choice = $choiceArray['choice'];
		}
		//得到板块名字
		$thisBlock = Goodsblock::where('id',$tid)->find();
		$blockName = $thisBlock['block_name']; //小版块名字
		$pid = $thisBlock['pid'];
		$bigBlock = Goodsblock::where('id',$pid)->find();
		$bigBlockName = $bigBlock['block_name'];
		$this->assign('bigBlockName',$bigBlockName);
		$this->assign('blockName',$blockName);
		$goods = new goo;
		$this->assign('tid',$tid);
		//人气商品数据（左边）
		$hotGoods = $goods->where('goodsblock_id',$tid)->limit(6)->order('sold_num','desc')->select();
		$i = 1;
		$this->assign('i',$i);  //用来给人气商品排序
		$this->assign('hotGoods',$hotGoods);

		//最新商品数据(左边)
		$newGoods = $goods->where('goodsblock_id',$tid)->order('create_time','desc')->limit(3)->select();
		$this->assign('newGoods',$newGoods);

		if($choice==0){
			//最新商品数据(中间)
			$newList = goo::where('goodsblock_id',$tid)->paginate(6);
			$newPage = $newList->render();
			$this->assign('newList',$newList);
			$this->assign('newPage',$newPage);
		}elseif($choice==1){
			//按价格降序显示商品
			$newList = goo::where('goodsblock_id',$tid)->order('price','asc')->paginate(6);
			$newPage = $newList->render();
			$this->assign('newList',$newList);
			$this->assign('newPage',$newPage);
		}else{ 
			//积分不够或者没登录
			if(empty(Session::get('uid'))){
				$this->error('请登录','__SITE__/index/auth/login');
			}
			$uid = Session::get('uid');
			$user = User::where('id',$uid)->find();
			$score = $user['score'];
			$newList = Db::table('g_goods')->where('goodsblock_id',$tid)->where('price','<',$score)->paginate(6);

			$data = '您的积分不够';
			$this->assign('data',$data);
			$newPage = $newList->render();
			$this->assign('newList',$newList);
			$this->assign('newPage',$newPage);
			
			
		}
		
		return $this->fetch();
	}

	//填写收货地址信息
	public function shoppingAddress()
	{
		if(empty(Session::get('uid'))){
			$this->error('请先登录','__SITE__/index/auth/login');
		}
		$user = new User;
		$uid = Session::get('uid');
		$defaultData = $user->where('id',$uid)->find();
		$this->assign('defaultData',$defaultData);


		return $this->fetch();
	}

	public function doAddress()
	{
		$user = new User;
		$province = $_REQUEST['home_province'];
		if(empty($province)){
			$this->error('省份不得为空');
		}

		$city = $_REQUEST['home_city'];
		if(empty($city)){
			$this->error('地区不得为空');
		}

		$street = $_REQUEST['addressdetail'];
		if(empty($street)){
			$this->error('街道不得为空');
		}

		$address = $province.$city.$street; //得到具体地址
		
		$username = $_REQUEST['user_name'];

		$phone = $_REQUEST['mobile'];
		if(strlen($phone)<11){
			$this->error('请输入有效的手机号');
		}

		$uid = Session::get('uid');
		$result = $user->save([
				'shopping_address' => $address,
				'shopping_phone' =>$phone,
				'shopping_name' =>$username,

			],['id'=>$uid]);
		if($result){
			$this->success('收货信息已填写完整','__SITE__/index/goods/goods');
		}else{
			$this->error('收货信息插入数据库不成功');
		}
	}

	//订单信息
	public function order()
	{
		
		if(empty(Session::get('uid'))){
			$this->error('请登录','__SITE__/index/auth/login');
		}
		//个人信息
		$user = new User;
		$uid = Session::get('uid');
		$defaultData = $user->where('id',$uid)->find();
		$this->assign('defaultData',$defaultData);

		//订单信息
		$order = new Order;
		$orderList = $order->where('user_id',$uid)->select();
		$this->assign('orderList',$orderList);
		return $this->fetch();
	}
	
}
