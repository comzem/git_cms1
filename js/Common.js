
function del_check(form,form1)
{
if(confirm("确实要删除选中的项吗？")==1){
form.action=form1+"?act=delete";
form.submit();
return true;
}
return false;
}

function getDel(k,inid,form){
if (confirm("确定要删除吗！")){		
  $.get(form+"?act=delete1",{id:inid},function(result){
if (result)
	$(k).parent().parent().remove();
else
	alert("无法删除！");
});
  return true;
}
  return false;
} 

function add_child(sty,adr,id){		
var str_1="<ul class='ulclass_2'> <li id='ulclass_li_0'><input type='text' name='add_sort[]' /></li><li id='"+sty+"'><input type='text' name='add_title[]' /><a href='javascript:;' onclick='remove_child(this)'><img src='images/xx.gif' border='0' /></a></li><li class='add_w_3'><input type='hidden' name='add_level_id[]' value='"+id+"'></li></ul>";
$(adr).append(str_1);
}

function remove_child(k){
	$(k).parent().parent().remove();
	return true;
}

$(function()
{
	$(":text,.w250").focus(function(){
		$(this).addClass("input_move");
		
	 });
	 
	 $(":text,.w250").blur(function(){
			$(this).removeClass("input_move");
	 });
	 
	$("#chkAll").change(function(){
		$("input[name='check_id[]']").each(function(){ 
		if($(this).attr("checked")){ 
			$(this).removeAttr("checked"); 
		} 
		else { 
			$(this).attr("checked","true"); 
		} 
		}) 
	})

//加载分类，评论
//分类信息
$(".typetitle").each(function(index, element) {
    $(this).load("/inc/ajax.php?tab=part&cid="+$(this).attr("cid")+"&tm="+(new Date()).getTime());
});

$(".pinglun").each(function(index, element) {
    $("#pinglun_"+$(this).attr("eid")).load("../includes/ajax.php?tab=pinglun&eid="+$(this).attr("eid")+"&tid="+$(this).attr("tid")+"&tm="+(new Date()).getTime());
});

//地图选择

$("#checkmap").click(function(){
	$("#container").show().css({
		left:$(this).offset().left+"px",
		top:$(this).offset().top-500+"px"
	});	
});
$("#mapclose").click(function(){
	$("#container").hide();
});

//////////////////////////////////////////////////////////////////////////////


//更新属性
$(".editp").live("click",function(){	
	var infd=$(this).attr("field");	
	var editval=$(this).attr("val");
	var inid=$(this).attr("id");
	$url=$("#url").val();
	$.post($url,{id:inid,fd:infd,val:editval},function(data){		

	});
	if (editval=="0"){
		$(this).attr({
			"src":"images/no.gif",
			"val":"1"
		});
	}else{
		$(this).attr({
			"src":"images/yes.gif",
			"val":"0"
		});
	}
});

/************改价*************/
$(".gaijia").click(function(){
	if (confirm('确定修改吗')==false){
		return false;
	}
	var fid=$("#fid").val();
	var p=$("#editprice").val();
	if (p+"a"=="a"){
		alert("请输入价格");
		return false;
	}
	var s=$(this).attr("s");
	location.href="?action=product&operation=setnc&fid="+fid+"&p="+p+"&s="+s;

});




$(".edit").hover(
	function(){
		$(this).css({
			background:"#cccccc"
		});
	},
	function(){
		$(this).removeAttr("style");
	}
);

  $(".admin_submit").hover(
  	function(){
		$(this).addClass("admin_submit_hover");
		},
	function(){
		$(this).removeClass("admin_submit_hover");
		}
  );
  
  $(".zx_total").each(function(index, element) {
     $(this).load("/inc/ajax.php?t=comments_total&fid=1&pid="+$(this).attr("id")+"&tm="+(new Date).getTime());
  });
  
  $(".pl_total").each(function(index, element) {
     $(this).load("/inc/ajax.php?t=comments_total&fid=2&pid="+$(this).attr("id")+"&tm="+(new Date).getTime());
  });
 

});