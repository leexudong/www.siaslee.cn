
    $(function(){
        bind_re();
    });
    function ajaxgopages(page,comment_id,ele){
        var _this=$(ele);
        var page_total=_this.parent().children(".page_total").val();
        var current_page=_this.parent().children(".current_page").val();
        page_total=parseInt(page_total);
        current_page=parseInt(current_page);
        if(page=='page_down'){
            var page=current_page+1;
        }else{
            var page=current_page-1;
        }
        var forum_id=$("#fid").val();
        var obj_id=$("#obj_id").val();
        $.post("/ajax/comment_reply_zt.php",{"page":page,"forum_id":forum_id,"obj_id":obj_id, "comment_id":comment_id }, function(data){
            _this.parent().parent().children(".page1").html(data);
            if(page<1) page=1;
            _this.parent().children(".current_page").val(page);
            if(page<=1){
                _this.parent().children(".page_up").hide();
            }else{
                _this.parent().children(".page_up").show();
            }
            if(page>=page_total){
                _this.parent().children(".page_down").hide();
            }else{
                _this.parent().children(".page_down").show();
            }
        },"html");
    }
    function bind_re(){
    $(".re_slideUp").unbind();
    $(".viewmorepls").click(function(){
        $(this).parent().parent().children(".page1").children("li").show();
        $(this).parent(".morepls").hide();
        $(this).parent(".morepls").next().show();
    });
    $(".re_slideUp").click(function(){
        var _this=$(this);
        _this.parents(".plcon").next().slideUp(function(){
            _this.html("展开回复");
            _this.removeClass("re_slideUp").addClass("re_slideDown");
            bind_re();
        });
    });
    $(".re_slideDown").unbind();
    $(".re_slideDown").click(function(){
        var _this=$(this);
        _this.parents(".plcon").next().slideDown(function(){
            _this.html("收起回复");
            _this.removeClass("re_slideDown").addClass("re_slideUp");
            _this.parents(".plcon").next().find("textarea").focus();
            bind_re();
        });
    });
    $(".re_start").unbind();
    $(".re_start").click(function(){
        $(".re_slideUp1").html("回复");
        $(".re_slideUp1").parents(".plcon").next().slideUp(function(){
            $(".re_slideUp1").html("回复");
            $(".re_slideUp1").removeClass("re_slideUp1").addClass("re_start");
            bind_re();
        });
        var _this=$(this);
        _this.parents(".plcon").next().find("form").css("paddingTop","20px");
        _this.parents(".plcon").next().find("form").show();
        _this.parents(".plcon").next().slideDown(function(){
            _this.html("收起");
            _this.removeClass("re_start").addClass("re_slideUp1");
            _this.parents(".plcon").next().find("textarea").focus();
            bind_re();
        });
    });
    $(".re_slideUp1").unbind();
    $(".re_slideUp1").click(function(){
        var _this=$(this);
        _this.parents(".plcon").next().slideUp(function(){
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
    $(".re_submit").unbind("click").click(function(){
        var _this = $(this);
        _this.attr('disabled','disabled'); 
        // alert('ff');
        var repid=_this.prev(".reply_id").val();
        var saytext=_this.parent().children(".re_textarea").val();
        var fid=$("#fid").val();
        var obj_id=$("#obj_id").val();
        var user_id=$("#user_id").val();
        var caidan_id=$("#caidan_id").val();
        var user_name=$("#user_name").val();
        var user_avatar=$("#user_avatar").val();
        var reply_html='<li class="clearfix "><a class="avatar1" href="http://i.meishi.cc/cook.php?id='+user_id+'" target="_blank"><img src="'+user_avatar+'"></a><div class="c1"><p class="p2"><a href="http://i.meishi.cc/cook.php?id='+user_id+'" target="_blank">'+user_name+'</a>: '+saytext+'</p><div class="info1"><span>刚刚</span></div></div></li>';
        $.post("/pl/comment.php", {"saytext": saytext,"repid":repid, "ecmsfrom":"json","wm":"","obj_id":obj_id,"fid":fid,"caidan_id":caidan_id, "format":"json","comment_from":"zt" },
           function(data){
            if(data.code==1){
                _this.parent().children(".re_textarea").val("");
                _this.parent().parent().children(".page1").append(reply_html);
                _this.removeAttr('disabled');
            }else if(data.code==-1){
                alert(data.msg);
                _this.removeAttr('disabled'); 
            }
        }, "json");
    });
    $(".topic_submit").unbind("click").click(function(){
        var saytext=$(".saytext").val();
        if(saytext==''){
            alert('请输入要评论的内容');return false;
        }
    });
    $(".saytext").unbind("click").click(function(){
        var user_id=$("#user_id").val();
        if(!user_id){
            location.href = "http://i.meishi.cc/login.php?redirect=" + encodeURIComponent(location.href);
        }
    });
    $("#msjzt_sidescbtn").unbind("click").click(function(){
        var caidan_id=$("#caidan_id").val();
        $.post("/ajax/caidan/shoucang.php",{ type:1,cid:caidan_id,obj_type:'gf' },function(result){
            var obj = result;
            if(obj.code == 0){
                alert('收藏成功');       
                
            }else if(obj.code == 3){
                location.href = 'http://i.meishi.cc/login.php?redirect=' + encodeURIComponent(location.href);
            }else{
                alert(obj.detail);
            }
        },'json');
    });
}
$(function(){
    var bdPic="";
    if($("#bdPic")){
        bdPic=$("#bdPic").val();
    }
    var bdText="";
    if($("#bdText")){
        bdText=$("#bdText").val();
    }
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":bdText,"bdMini":"2","bdMiniList":false,"bdPic":bdPic,"bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"100"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
})