<?php 
include dirname(dirname(__FILE__)).'/inc/init_cms.php';

$act=C::get('act');
$backurl=C::get('url');
if (isset($act) && $act=='login'){
	require ACTION_PATH.'members.php';
	$members=new members();
	$login=$members->login();
	list($uid,$username,$gid)=$login;
	if ($uid>0){
		$url=C::get('backurl');
		C::msg('', $url,'parent');
	}else{
		switch ($uid){
			case '-1':
				C::msg('账号不存在', '-1');
				break;
			case '-2':
				C::msg('密码错', '-1');
				break;
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员登陆</title>
<script type="text/javascript" src="/js/jquery.js"></script>
<style type="text/css">
body{
	margin:0px auto;
	font-size:12px;
	}
.dengru_input {
	border: 1px solid #ccc;
	height: 25px;
	line-height: 25px;
	width: 160px;
}
.dengru_bg {
	background: url(/images/dengru.gif) no-repeat;
	width: 79px;
	height: 28px;
	border: 0px;
	cursor:pointer;
}
#lmsg{
	color:#ff0000;
}
</style>
<script>
String.prototype.trim = function () { return this.replace(/(^\s*)|(\s*$)/g, ""); }
$(function(){
	$("#denglu").click(function(){				
		if ($("#username").val().trim()=="" || $("#password").val().trim()==""){
			$("#lmsg").html("请输入帐号或密码。");
			$("#lmsg").addClass("lmsg");
			return false;
		}else if($("#verifycode").val().trim()==""){
			$("#lmsg").html("请输入验证码。");
			$("#lmsg").addClass("lmsg");
			return false;
		}else{
			return true;
		}
	});
});
    </script>
</head>

<body>
<form action="?act=login" method="post">
<input name="backurl" type="hidden" value="<?php echo $backurl; ?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="5" id="logintab">
    <tr>
      <td></td>
      <td id="ShowTip"></td>
    </tr>
    <tr>
      <td width="85" align="right">用户名：</td>
      <td><input name="username" type="text" class="dengru_input" id="username" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">密　码：</td>
      <td><input name="password" type="password" class="dengru_input" id="password" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
     <td align="right">验证码：</td>
     <td>
     <div style="float:left;">
     <input name="verifycode" id="verifycode" type="text" size="4" maxLength="4">
     </div><div style="float:left; padding-left:8px;">
     <img src="/inc/vcode.php?t=general" onclick="this.src='/inc/vcode.php?'+Math.random()+'&t=general'" />
     </div>
     </td>
     <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="denglu" id="denglu" type="submit" class="dengru_bg" value=""></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div class="zhuche_msg">还没有账号？<a href="/my/reg.php" id="zhuce" target="_parent">立即注册</a></div></td>
      <td></td>
    </tr>
    <tr>
    <td></td>
    <td colspan="2"><div id="lmsg"></div></td></tr>
  </table>
</form>
</body>
</html>