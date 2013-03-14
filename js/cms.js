// JavaScript Document
$(function(){
	$("#zhixun").click(function(){
		var user=$("#username").val();
		var u_id=$("#uid").val();
		var myDate = new Date();
		var mytime=myDate.toLocaleTimeString(); 
		var _content=$("#ask_text").val();
		var _fid=$("#ask_text").attr("fid");
		if (_content==''){
			alert('内容必须填写');
			return false;
		}
		var product_id=$("#product_id").val();
		//alert(user+','+u_id+','+myDate+','+_content+','+_fid+','+product_id);
		var msg="<ul class=\"mat5\"><li class=\"fl\">会员："+user+"</li><li class=\"fr\">咨询日期："+mytime+"</li></ul><div class=\"padb10 mal10 lh18\"><div class=\"mat10 font14\">"+_content+"</div></div>";
		$.post("/inc/ajax.php?t=goods_comments&tm="+(new Date).getTime(),{uid:u_id,username:user,content:_content,pid:product_id,fid:_fid},function(data){
			if (data>0){
				$("#js_askhtml").append(msg);
				$("#ask_text").val('');
			}else if (data==-1){
				alert("请先登陆");
				return false;
			}else if (data==-2){
				alert("请不要连续提交留言");
				return false;
			}else if (data==-3){
				alert("留言提交成功，审核中？");
				return false;
			}else if (data==-4){
				alert("咨询已关闭？");
				return false;
			}	
		});
	});
	
	$("#pinglun").click(function(){
		var user=$("#username").val();
		var u_id=$("#uid").val();
		var myDate = new Date();
		var mytime=myDate.toLocaleTimeString(); 
		var _content=$("#comment_text").val();
		var _fid=$("#comment_text").attr("fid");
		if (_content==''){
			alert('内容必须填写');
			return false;
		}
		var product_id=$("#product_id").val();
		var msg="<ul class=\"mat5\"><li class=\"fl\">会员："+user+"</li><li class=\"fr\">咨询日期："+mytime+"</li></ul><div class=\"padb10 mal10 lh18\"><div class=\"mat10 font14\">"+_content+"</div></div>";
		
		$.post("/inc/ajax.php?t=goods_comments&tm="+(new Date).getTime(),{uid:u_id,username:user,content:_content,pid:product_id,fid:_fid},function(data){	
			if (data>0){
				$("#js_pjhtml").append(msg);
				$("#comment_text").val('');
			}else if (data==-1){
				alert("请先登陆");
				return false;
			}else if (data==-2){
				alert("请不要连续提交留言");
				return false;
			}else if (data==-3){
				alert("留言提交成功，审核中？");
				return false;
			}else if (data==-4){
				alert("评论已关闭？");
				return false;
			}
		});
	});
	
	$("#tijiao").click(function(){
		var t=$("#subject").val();
		var c=$("#content").val();
		$.post("/inc/ajax.php?t=goods_comments&tm="+(new Date).getTime(),{subject:t,content:c},function(data){	
			if (data>0){
				$("#js_pjhtml").append(msg);
				$("#subject").val('');
				$("#content").val('');
			}else if (data==-1){
				alert("请先登陆");
				return false;
			}else if (data==-2){
				alert("请不要连续提交留言");
				return false;
			}
		});
	})
	
	$(".showmsg").live("click",function(){
		var fid=$("#fid").val();
		var pid=$("#product_id").val();
		var show=$("#showdiv").val();
		$("#"+show).load("/inc/comment.php?type=goods&fid="+fid+"&pid="+pid+"&tm="+(new Date()).getTime());
	});
	$(".pageclass").live("click",function(){
		var fid=$("#fid").val();
		var pid=$("#product_id").val();
		var pageCurrent=$(this).attr("p");
		var show=$("#showdiv").val();
		$("#"+show).load("/inc/comment.php?type=goods&fid="+fid+"&pid="+pid+"&p="+pageCurrent+"&tm="+(new Date()).getTime());
	});
	
	//$("#pl_total").load("/inc/ajax.php?t=comments_total&fid=1&pid="+$("#product_id").val()+"&tm="+(new Date).getTime());
})