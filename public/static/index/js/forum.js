$(function(){
	if ($('#forum_index_focusimg li').length > 0) {
		$('#forum_index_focusimg li').soChange({
			thumbObj: '#forum_index_focusimg_num li a',
			type: "fade"
		})
	}
$("#chosepostskind").hover(function(){
	$(this).addClass("on");
},function(){
	$(this).removeClass("on");
});
$(".fortab").click(function(){
	var _this = $(this);
	var _t = _this.attr("tab");
	_this.parents("dl").find("dd").hide();
	_this.parents("dl").find(".dd"+_t).show();
	_this.siblings("em").removeClass("current");
	_this.addClass("current");
});
bind_re();
});
function bind_re(){
	$(".re_slideUp").unbind();
	$(".viewmorepls").click(function(){
		$(".page1 li").show();
		$(this).parent(".morepls").hide();
		$(this).parent(".morepls").next().show();
	});
	$(".re_slideUp").click(function(){
		var _this=$(this);
		_this.parents(".info").next().slideUp(function(){
			_this.html("展开回复");
			_this.removeClass("re_slideUp").addClass("re_slideDown");
			bind_re();
		});
	});
	$(".re_slideDown").unbind();
	$(".re_slideDown").click(function(){
		var _this=$(this);
		_this.parents(".info").next().slideDown(function(){
			_this.html("收起回复");
			_this.removeClass("re_slideDown").addClass("re_slideUp");
			_this.parents(".info").next().find("textarea").focus();
			bind_re();
		});
	});
	$(".re_start").unbind();
	$(".re_start").click(function(){
		var _this=$(this);
		_this.parents(".info").next().find("form").css("paddingTop","20px");
		_this.parents(".info").next().find("form").show();
		_this.parents(".info").next().slideDown(function(){
			_this.html("收起");
			_this.removeClass("re_start").addClass("re_slideUp1");
			_this.parents(".info").next().find("textarea").focus();
			bind_re();
		});
	});
	$(".re_slideUp1").unbind();
	$(".re_slideUp1").click(function(){
		var _this=$(this);
		_this.parents(".info").next().slideUp(function(){
			_this.html("回复");
			_this.removeClass("re_slideUp1").addClass("re_start");
			bind_re();
		});
	});
	$(".saybtn").toggle(function(){
		var _this = $(this);
		_this.html("收起");
		_this.addClass("saybtn_ed");
		_this.next().slideDown(function(){
			_this.next().find("textarea").focus();
		});
	},function(){
		var _this = $(this);
		_this.html("我也说一句");
		_this.removeClass("saybtn_ed");
		$(this).next().slideUp(function(){
		});
	});
}