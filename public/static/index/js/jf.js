$(function(){

	$("#tq_tip").hover(function(){
		$(this).addClass("tq_tip_show");
	},function(){
		$(this).removeClass("tq_tip_show");
	});



	$("#givestars_show span").mouseenter(function(){

		var lv = $(this).attr("star");
		$("#givestars_show").removeClass().addClass("givestars_show_"+lv);

	});

	$("#givestars_show").mouseleave(function(){
		if($(this).attr("chosed") < 0){
			$(this).removeClass().addClass("givestars_show_0");
		}else{
			var s = $(this).attr("chosed");
			$(this).removeClass().addClass("givestars_show_"+s);
		}
		
	});


	$("#givestars_show span").click(function(){
		var s = $(this).attr("star")
		$("#usergivestars").val(s);
		$("#givestars_show").attr("chosed",s);

	});




	$(".buy_bum").change(function(){
		var price = parseInt($("#goodspriceincon").html());
		var userjf = parseInt($("#userjfincon").html());
		var num = $(this).val();
		if(userjf<(num*price)){
			$("#sy_unable_bbtn").show();
			$("#sy_bbtns").hide();
		}else{
			$("#sy_unable_bbtn").hide();
			$("#sy_bbtns").show();
		}
	});

	$(".buy_bum").keyup(function(){
		var price = parseInt($("#goodspriceincon").html());
		var userjf = parseInt($("#userjfincon").html());
		var num = $(this).val();
		if(userjf<(num*price)){
			$("#sy_unable_bbtn").show();
			$("#sy_bbtns").hide();
		}else{
			$("#sy_unable_bbtn").hide();
			$("#sy_bbtns").show();
		}
	});






    if ($('#dr_top_box_ul1 li').length > 0) {
        $('#dr_top_box_ul1 li').soChange({
            thumbObj: '#dr_top_num_ul1 li a',
            type: "fade"
        })
    }   var drli = "";
    












$(".zt_list2_li").mouseenter(function(){
		$(this).find("div.i").stop().animate({marginTop:"-95px"},400,function(){});
	});
	$(".zt_list2_li").mouseleave(function(){
		$(this).find("div.i").stop().animate({marginTop:"0px"},400,function(){});
	});
	$("#to_wb").click(function(){
		$(this).addClass("current").siblings().removeClass("current");
		$("#zt_wbshow").show();
		$("#zt_plshow").hide();
	});
	$("#to_pl").click(function(){
		$(this).addClass("current").siblings().removeClass("current");
		$("#zt_plshow").show();
		$("#zt_wbshow").hide();
	});

$(".goodsmore").toggle(function(){
		$(this).parent().find(".goodsmore_con").slideDown();
		$(this).html("收起 △");
	},function(){
		$(this).parent().find(".goodsmore_con").slideUp();
		$(this).html("订单详情 ▽");
});






$(".jjg_goodscon_right_maintab span").click(function(){
	var toShow = $(this).attr("tab");
	var toHide = [];
	$.each($(this).siblings(),function(){
		toHide.push($(this).attr("tab"));
	})

	$(".jjg_goodscon_right_maintab1_con[fortab="+toShow+"]").show();

	$.each(toHide,function(i,n){
		$(".jjg_goodscon_right_maintab1_con[fortab="+n+"]").hide();
	});

	$(this).addClass("current");
	$(this).siblings().removeClass("current")

});




$(".jwd_goodsinfo_list_li .remove").click(function(){

	var inp = $(this).siblings(".forwrite").find("input");
	var num = inp.val();
	if(num >= 2){
		num --;
		inp.val(num);
	}

	var price_item = $(this).parent().siblings(".price");
	var price = parseInt(price_item.html());
	var zk_item = $(this).parent().siblings(".zk").find(".zk_num");
	var zk = zk_item.html();
	var totalprice = (num*price*zk)/10;
	$(this).parent().siblings(".totalprice").html(totalprice+"积分");

});


$(".jwd_goodsinfo_list_li .add").click(function(){
	var inp = $(this).siblings(".forwrite").find("input");
	var num = inp.val();
	num ++;
	inp.val(num);
	var price_item = $(this).parent().siblings(".price");
	var price = parseInt(price_item.html());
		var zk_item = $(this).parent().siblings(".zk").find(".zk_num");
	var zk = zk_item.html();
	var totalprice = (num*price*zk)/10;
	$(this).parent().siblings(".totalprice").html(totalprice+"积分");
});





$("#jwd_addlist input:radio").live("change",function(){

	if($(this).attr("id") != "add_new_address"){
		$("#add_new_add_box").slideUp();
	}

});





$(".jwd_addlist li").live("mouseenter",function(){
	$(this).css("background","#fafafa");
	$(this).find(".morenadd").show();
	$(this).find(".setmoren").show();
	$(this).find(".editaddress").show();
	$(this).find(".deladdress").show();
});

$(".jwd_addlist li").live("mouseleave",function(){
	$(this).css("background","none");
	$(this).find(".morenadd").hide();
	$(this).find(".setmoren").hide();
	$(this).find(".editaddress").hide();
	$(this).find(".deladdress").hide();
});




$("#add_new_address").change(function(){
	var _this = $(this);
	if(_this.attr("checked") == "checked"){
		$("#add_new_add_box").slideDown();
	}
});







$("#jjg_addtocart").click(function(){



	if(1){
		$("#jjg_addcarttip").addClass("jjg_addsuc").fadeIn(function(){
			setTimeout(function(){$("#jjg_addcarttip").fadeOut();},3000);
		});
	}else{
		$("#jjg_addcarttip").addClass("jjg_addfail").fadeIn(function(){
			setTimeout(function(){$("#jjg_addcarttip").fadeOut();},3000);
		});
	}

});



start_sy_djs();

$("#jf_willbuy_rarr").click(function(){
	var _ul = $("#jf_willbuy_con_ul");
	_ul.animate({"margin-left":-450+"px"},500,function(){
		_ul.find("li").first().appendTo(_ul);
		_ul.css("margin-left","-225px");
	});


});


$("#jf_willbuy_larr").click(function(){
	var _ul = $("#jf_willbuy_con_ul");
	_ul.animate({"margin-left":0+"px"},500,function(){
		_ul.find("li").last().prependTo(_ul);
		_ul.css("margin-left","-225px");
	});


});




if ($('#jfindex_imgbox_ul li').length > 0) {
	$('#jfindex_imgbox_ul li').soChange({
	thumbObj: '#jfindex_num_ul li a',
	type: "fade"
	})
}


if ($('#goodsinfo_imgbox_ul li').length > 0) {
	$('#goodsinfo_imgbox_ul li').soChange({
	thumbObj: '#goodsinfo_num_ul li a',
	type: "fade"
	})
}



if ($('#dr_top_box_ul li').length > 0) {
	$('#dr_top_box_ul li').soChange({
	thumbObj: '#dr_top_num_ul li a',
	type: "fade"
	})
}


$("#dsf_weixin a").hover(function(){
	$(this).stop().animate({"height":"252px"},300,function(){});
},function(){
	$(this).stop().animate({"height":"48px"},300,function(){});
});


$(".jjg_menu_item").mouseenter(function(){
	var _this = $(this);
	_this.addClass("jjg_menu_item_current");

});
$(".jjg_menu_item").mouseleave(function(){
	var _this = $(this);
	_this.removeClass("jjg_menu_item_current");
});



set_jjg_newgoods_interval();

$("#jjg_newgoods_list_dot li").hover(function(){

	
	var _this = $(this);
	var flag = _this.attr("flag");
	var po = (flag-1)*252;
	$("#jjg_newgoods_list").animate({"margin-left":-po+"px"},400,function(){
		_this.siblings().removeClass("current");
		_this.addClass("current");
	});

},function(){
	
});

$("#jjg_newgoods_list").mouseenter(function(){
	clearInterval(jjg_newgoods_interval);
});
$("#jjg_newgoods_list").mouseleave(function(){
	set_jjg_newgoods_interval();
});




});


var jjg_newgoods_interval;
function set_jjg_newgoods_interval(){
	jjg_newgoods_interval = setInterval(function(){

		var flag = $("#jjg_newgoods_list_dot li.current").attr("flag");
		var l =$("#jjg_newgoods_list_dot li").length;
		if(flag == l){flag = 0}
		var po = (flag)*252;

		$("#jjg_newgoods_list").animate({"margin-left":-po+"px"},400,function(){

			if($("#jjg_newgoods_list_dot li.current").next().length > 0){
				$("#jjg_newgoods_list_dot li.current").next().addClass("current").siblings().removeClass("current");
			}else{
				$("#jjg_newgoods_list_dot li").removeClass("current");
				$("#jjg_newgoods_list_dot li").first().addClass("current")
			}
		});
		
	},3000);
}




var sy_djs_itvl;
var sy_djs_stopflag = 0;
function start_sy_djs(){
	var x = $("#sy_djs");
	sy_djs_itvl = setInterval(function(){sy_djs(x);},1000);
}
function stop_sy_djs(){
	clearInterval(sy_djs_itvl);
}
function sy_djs(item){
	var day = item.find(".day").html();
	var hour = item.find(".hour").html();
	var minute = item.find(".minute").html();
	var second = item.find(".second").html();


	if(day==0 && hour==0 && minute==0 && second==0){

		$("#sy_bbtns").css({"background":"#eee","color":"#999","cursor":"default"});
		$("#sy_bbtns").attr("href","####");
		$("#sy_bbtns").html("申请结束");
		
	}else{

		if(second > 0){

			second --;

		}else{
			second = 59;
			if(minute > 0){
				minute --;
			}else{
				minute = 59;
				if (hour > 0 ){
					hour --;
				}else{
					hour = 23;
					if(day > 0){
						day--;
					}else{
						sy_djs_stopflag = 1;
						stop_sy_djs();
					}
				}
			}
		}

			
	}
	item.find(".day").html(day);
	item.find(".hour").html(hour);
	item.find(".minute").html(minute);
	item.find(".second").html(second);


}




function start_sy_djs_1(item,i){

	var x = item;
	var y = eval("sy_djs_itvl_"+i+"='';");

	y = setInterval(function(){sy_djs_1(x,i);},1000);
}
function stop_sy_djs_1(item,i){
	var j =  eval("sy_djs_itvl_"+i);
	clearInterval(j);
}
function sy_djs_1(item,i){
	var day = item.find(".day").html();
	var hour = item.find(".hour").html();
	var minute = item.find(".minute").html();
	var second = item.find(".second").html();


	if(day==0 && hour==0 && minute==0 && second==0){

		var btn = item.parents(".c").find(".btn");

		btn.css({"background":"#eee","color":"#999","cursor":"default"});
		btn.attr("href","####");
		btn.html("申请结束");
		
	}else{

		if(second > 0){

			second --;

		}else{
			second = 59;
			if(minute > 0){
				minute --;
			}else{
				minute = 59;
				if (hour > 0 ){
					hour --;
				}else{
					hour = 23;
					if(day > 0){
						day--;
					}else{
						sy_djs_stopflag = 1;
						stop_sy_djs_1(item,i);
					}
				}
			}
		}

			
	}
	item.find(".day").html(day);
	item.find(".hour").html(hour);
	item.find(".minute").html(minute);
	item.find(".second").html(second);


}


function makeImgToRightSize(){
	$.each($(".uploadimg_items_show"),function(){
		var w = $(this).find(".uploadimg").width();
		var h = $(this).find(".uploadimg").height();

		
		if(w >= h){
			$(this).find(".uploadimg").height("100");
		}else{
			$(this).find(".uploadimg").width("100");
		}
	});
}



















