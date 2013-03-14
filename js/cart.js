$(function(){
	
	$(".cart_addess_out").hover(
		function(){
			$(this).addClass("cart_addess_over");
		},
		function(){
			$(this).removeClass("cart_addess_over");
		}
	);
	
	$(".cart_addess_out").click(function(){
		$(".cart_addess_out").each(function(index, element) {		
       		$("#address_"+(index+1)).removeClass("cart_addess_checked");
    	});
		$(this).addClass("cart_addess_checked");
		$("#order_addr").val($(this).attr("fid"));
	});	
	
	$("#new_address").live("click",function(){
		$("#TB_overlayBG").css({
			display:"block",height:$(document).height()
		});
		$("#new_address_add").css({
			display:"block"
		});
		
	});
	
	$("#new_address_close").click(function(){
		$("#TB_overlayBG").css({
			display:"none",height:0
		});
		$("#new_address_add").hide();		
	});
	
	//购买数量加减
	$("#jia").click(function(){
		//if (parseInt($("#kucun").attr("value"))>parseInt($("#product_num").val()))
			$("#product_num").val(parseInt($("#product_num").val())+1);
	});
	
	$("#jian").click(function(){
		var total=parseInt($("#product_num").val());
		if (total>1)
			$("#product_num").val(parseInt($("#product_num").val())-1);	
	});
	
	$("#product_num").blur(function(){
		if (parseInt($(this).val())<1)
			$(this).val("1");
		if (parseInt($("#kucun").attr("value"))<parseInt($(this).val()))
			$(this).val($("#kucun").attr("value"));
	});
	
	
	
	
	//增加购物车数量
	$(".plus").click(function(){
		var id=$(this).attr("id");
		var num_id="#nums_"+id;
		if (parseInt($(num_id).val())>0)
			$(num_id).val(parseInt($(num_id).val())+1);
		var p_num=$(num_id).val();
		var p_id=$("#product_id_"+id).val();
		var price=$("#prod_price1_"+id).attr("value");
		$("#total_price_"+id).html(parseInt(p_num)*parseInt(price));
		var money=$("#money").text();		
		
		$("#money").text(parseInt(money)+parseInt(price));
		
		$.get("/inc/ajax.php?t=cart&edit_num="+p_num+"&edit_id="+p_id,function(data){
			
		});
	});
	
	//减少购物车数量
	$(".minus").click(function(){
		var id=$(this).attr("id");
		var num_id="#nums_"+id;
		var total=parseInt($(num_id).val());
		var old_num=$(num_id).val();
		if (total>1)
			$(num_id).val(parseInt($(num_id).val())-1);
		var p_num=$(num_id).val();
		var p_id=$("#product_id_"+id).val();
		
		var price=$("#prod_price1_"+id).attr("value");
		$("#total_price_"+id).html(parseInt(p_num)*parseInt(price));
		var money=$("#money").text();
		if (parseInt(old_num)-parseInt($(num_id).val())>0)
			$("#money").text((money)-parseInt(price));
		
		$.get("/inc/ajax.php?t=cart&edit_num="+p_num+"&edit_id="+p_id,function(data){
			
		});
	});
	
	$(".input_1").blur(function(){
		if (parseInt($(this).val())<1)
			$(this).val("1");
	});
	
	//删除订单
	$(".delete_order").click(function(){
		var id=$(this).attr("id");
		var money=$("#money").attr("value");
		var price=$("#prod_price1_"+id).attr("value");
		if (confirm("确定删除订单吗？")){
			$.get("/inc/ajax.php?t=delete_order&id="+id,function(data){	
				if (parseInt(data)>0 && parseInt(data)!=NaN){					
					$(this).parent().parent().remove();					
					$("#money").html(parseInt(money)-parseInt(price));					
				}else{
					$("#cart_yes").hide();
					$("#cart_no_goods").show();
				}
			});
			
		}else{
			return false;
		}
	});

	
	//提交订单
	
	$("#txt_remark").focus(function(){
		$(this).addClass("input_remark");
	});
	
	$("#txt_remark").blur(function(){		
		if ($(this).val()==""){
			$(this).removeClass("input_remark");
		}
	})
	

	
	/**************判断是否登陆************/
	$("#buy_order").click(function(){
		$.get("/inc/ajax.php?t=user_status",function(data){
			if (data==1){
				location.href="confirm_order.php";
			}else{
				open_dg('会员登陆','/my/layer.php?url=/shop/order/confirm_order.php');
			}
		})		
	});
	
	$(".close").click(function(){
		$("#TB_overlayBG").css("display","none");
		$(".box ").css("display","none");
	});
	
	//加入购物车
	$("#add_cart").click(function(){
		var p_num=$("#product_num").val();
		var p_id=$("#product_id").val();
		$.get("/inc/ajax.php?t=addcart&p_num="+p_num+"&p_id="+p_id,function(data){
			if (data=="1"){
				alert("已添加到购物车！");
			}
		});
	});
	
	
	//添加新收货地址
	$("#addressbtn").click(function(){
		var txt_cname=$("#txt_cname").val();
		var area1=$("#txt_province").val();
		var area2=$("#txt_city").val();
		var area3=$("#txt_county").val();
		var txt_address=$("#txt_address").val();
		var txt_zip=$("#txt_zip").val();
		var txt_tel_code=$("#txt_tel_code").val();
		var txt_tel=$("#txt_tel").val();
		var txt_mobile=$("#txt_mobile").val();
		//var email=$("#txt_email").val();
		//var default_addr=$("#txt_default_addr").val()
		
		$.post("/inc/ajax.php?t=addradd",{cname:txt_cname,province:area1,city:area2,county:area3,address:txt_address,zip:txt_zip,tel_code:txt_tel_code,tel:txt_tel,mobile:txt_mobile,email:"",default_addr:"N"},function(data){
			$("#order_addr").val(data);
			var add_content="<li><div class='cart_addess_checked' id='address_"+data+"' fid='"+data+"'><div class='cart_padd'> <font style='font-size:14px;'>"+area1+" <b>"+area2+"</b></font> ("+txt_cname+" 收) <br />"+area3+" "+txt_address+" <span>"+txt_mobile+" </span> </div></div></li>";
			
			$(".cart_addess_ul").append(add_content);
			$(".cart_addess_out").each(function(index, element) {		
				$(this).removeClass("cart_addess_checked");
			});
			$("#new_address_add").hide();
			$("#TB_overlayBG").css({
				display:"none",height:0
			});
		});
	});
	
	//提交新订单
	$("#cartadd").click(function(){
		if ($("#order_addr").val()+"a"=="a"){
			alert("请填写收货地址！");
		}else{
			$("#form1").submit();
		}
	});
	
	$(".simg").mouseover(function(){
		$(this).css({
			border:"1px solid #ff0000"
		}).siblings().removeAttr('style');
		var img=$(this).attr("src");
		$("#bimg").attr('src',img);
	});
	
	//选择属性
	$(".property li").click(function(){
		$(this).css({
			border:"1px solid #ff0000"
			}).siblings().removeAttr('style');
		var f=$(this).parent().attr("obj");
		$("#"+f).val($(this).attr("val"));
	});
	
	/***************地区选择**************/
	$("#txt_province").live("change",function(){
		var id=$(this).val();
		$.post("/inc/ajax.php?t=area&tm="+(new Date).getTime(),{txt:id},function(data){
			$("#txt_city").html(data);
			$("#txt_county").html("<option value=\"\">请选择区/县...</option>");
		})
		
	});
	
	$("#txt_city").live("change",function(){
		var id=$(this).val();
		$.post("/inc/ajax.php?t=area&tm="+(new Date).getTime(),{txt:id},function(data){
			$("#txt_county").html(data);
		})
	})
	
	$("#ajaxcart").click(function(){
		var num=$("#product_num").val();
		var id=$("#product_id").val();
		var input=$("#proinput").val();
		var input_arr=input.split(',');
		var property='';
		for(var i=0;i<input_arr.length;i++){
			if ($("#"+input_arr[i]).val()==""){
				alert("请选择属性！");
				return false;
			}else{
				property+=','+$("#"+input_arr[i]).val();
			}
		}
		//if (property.indexOf(',')>0){
			//alert(11);
			//property=property.substr(1);
		//}
		$.post("/shop/order/index.php?tm="+(new Date).getTime(),{product_num:num,product_id:id,property:property},function(data){
			open_dg("提示信息","/shop/order/tip.php");
		})
	});
	

	
});

/************打开层************/
function open_dg(title,url)
{
	$.dialog({
		lock:true,
		title:title,
		fixed: true,
		width: 380, 
    	height: 200,
		min:false,
		max:false,
    	content: 'url:'+url
	})
}