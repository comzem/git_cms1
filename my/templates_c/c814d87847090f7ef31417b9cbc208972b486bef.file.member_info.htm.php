<?php /* Smarty version Smarty-3.1.11, created on 2013-02-25 16:23:45
         compiled from "F:\cms\template\default\member_info.htm" */ ?>
<?php /*%%SmartyHeaderCode:24334512b1f91e9bfb8-95460162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c814d87847090f7ef31417b9cbc208972b486bef' => 
    array (
      0 => 'F:\\cms\\template\\default\\member_info.htm',
      1 => 1360318013,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24334512b1f91e9bfb8-95460162',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'keywords' => 0,
    'tpl' => 0,
    'path' => 0,
    'domain' => 0,
    'tab' => 0,
    'txt_uid' => 0,
    'txt_username' => 0,
    'txt_nick_name' => 0,
    'txt_real_name' => 0,
    'txt_email' => 0,
    'txt_user_tel' => 0,
    'txt_user_mobile' => 0,
    'user_sex_options' => 0,
    'user_sex_checked' => 0,
    'txt_user_qq' => 0,
    'txt_birthday' => 0,
    'txt_province' => 0,
    'txt_city' => 0,
    'txt_county' => 0,
    'txt_address' => 0,
    'txt_zip_code' => 0,
    'marital_status_options' => 0,
    'marital_status_checked' => 0,
    'txt_job' => 0,
    'txt_introduction' => 0,
    'looking_for_options' => 0,
    'looking_for_checked' => 0,
    'nature_options' => 0,
    'nature_checked' => 0,
    'txt_interests' => 0,
    'txt_favorite_music' => 0,
    'txt_favorite_books' => 0,
    'txt_favorite_movies' => 0,
    'txt_favorite_tv' => 0,
    'txt_favorite_game' => 0,
    'txt_favorite_sport' => 0,
    'txt_favorite_star' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_512b1f9216b588_24764961',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512b1f9216b588_24764961')) {function content_512b1f9216b588_24764961($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include 'F:\\cms\\Smarty\\plugins\\function.html_radios.php';
if (!is_callable('smarty_function_html_checkboxes')) include 'F:\\cms\\Smarty\\plugins\\function.html_checkboxes.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>会员中心</title>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['tpl']->value;?>
/css/style.css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['tpl']->value;?>
/css/userhead.css" rel="stylesheet"type="text/css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['tpl']->value;?>
/css/my.css" rel="stylesheet"type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/detail.js"></script>
<script type="text/javascript" src="../js/user.js"></script>
</head>
<body style="background:url(/images/user/head_basic.jpg) no-repeat top center;">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."my/myheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="bodyw"> <img src="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
<?php echo $_smarty_tpl->tpl_vars['tpl']->value;?>
/images/logo.gif" />
  <div class="bor1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="left" valign="top">
        
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."my/menu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        
        </td>
        <td class="right" valign="top">
        
        
<script type="text/javascript" src="/js/city.js"></script>

 
<script type="text/javascript">

String.prototype.trim = function () { return this.replace(/(^\s*)|(\s*$)/g, ""); }

function verify_nick_name() {
							var input_msg=document.getElementById("nick_name_msg");
				            if (document.getElementById("txt_nick_name").value.trim() == "") {
				                input_msg.className = "js_left";
				                input_msg.innerHTML = "不能为空";
				                return false;
				            }else {
				                input_msg.className = "js_left1";
				                input_msg.innerHTML = "";
				                return true;
				            }
				        }

function verify_email() {
				            var email = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

				            var input_msg=document.getElementById("email_msg");
				            if (!email.test(document.getElementById("txt_email").value)) {
				                input_msg.className = "js_left";
				                input_msg.innerHTML = "输入不正确";
				                return false;
				            }
				            else {
				                input_msg.className = "js_left1";
				                input_msg.innerHTML = "";
				                return true;
				            }            
				        }

function verify_user_tel() {
				            var telcode = /\d{3}-\d{8}|\d{4}-\d{7}/;
				            var input_msg=document.getElementById("user_tel_msg");
				            if (!telcode.test(document.getElementById("txt_user_tel").value)) {
				                input_msg.className = "js_left";
				                input_msg.innerHTML = "输入不正确";
				                return false;
				            }
				            else {
				                input_msg.className = "js_left1";
				                input_msg.innerHTML = "";
				                return true;
				            }            
				        }

function verify_user_mobile() {
							var input_msg=document.getElementById("user_mobile_msg");
				            if (document.getElementById("txt_user_mobile").value.trim() == "") {
				                input_msg.className = "js_left";
				                input_msg.innerHTML = "不能为空";
				                return false;
				            }else {
				                input_msg.className = "js_left1";
				                input_msg.innerHTML = "";
				                return true;
				            }
				        }

function verify_user_qq() {
				            var qq = /[1-9][0-9]{4,}/;

				            var input_msg=document.getElementById("user_qq_msg");
				            if (!qq.test(document.getElementById("txt_user_qq").value)) {
				                input_msg.className = "js_left";
				                input_msg.innerHTML = "输入不正确";
				                return false;
				            }
				            else {
				                input_msg.className = "js_left1";
				                input_msg.innerHTML = "";
				                return true;
				            }            
				        }

function verify_zip_code() {
				            var postcode = /[1-9]\d{5}(?!\d)/;

				            var input_msg=document.getElementById("zip_code_msg");
				            if (!postcode.test(document.getElementById("txt_zip_code").value)) {
				                input_msg.className = "js_left";
				                input_msg.innerHTML = "输入不正确";
				                return false;
				            }
				            else {
				                input_msg.className = "js_left1";
				                input_msg.innerHTML = "";
				                return true;
				            }            
				        }
function Result()
			{
				 if (verify_nick_name() && verify_email() && verify_user_tel() && verify_user_mobile() && verify_user_qq() && verify_zip_code())
				 {
				  return true;
				 }
				 else
				 {
				  alert("您的资料填写错误");
				  return false;
				 }
			}
</script> 

<form id="form1" action="<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
" method="post" name="form1">
  <div class="step_title">基本信息</div>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
    <tr style="display:none;">
      <td align="right" class="navi_link">用户ID：</td>
      <td align="left"><input type="text" name="txt_uid" id="txt_uid" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_uid']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">用户名：</td>
      <td align="left"><input type="hidden" name="txt_username" id="txt_username" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_username']->value;?>
' />
        <?php echo $_smarty_tpl->tpl_vars['txt_username']->value;?>
 </td>
    </tr>
    <tr>
      <td align="right" class="navi_link">* 昵 称：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="txt_nick_name" id="txt_nick_name" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_nick_name']->value;?>
' onblur="return verify_nick_name()" />
        </div>
        <div id="nick_name_msg"></div></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">姓 名：</td>
      <td align="left"><input type="text" name="txt_real_name" id="txt_real_name" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_real_name']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">* Email：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="txt_email" id="txt_email" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_email']->value;?>
' onblur="return verify_email()" />
        </div>
        <div id="email_msg"></div></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">固定电话：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="txt_user_tel" id="txt_user_tel" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_user_tel']->value;?>
' onblur="return verify_user_tel()" />
        </div>
        <div id="user_tel_msg"></div></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">* 手 机：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="txt_user_mobile" id="txt_user_mobile" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_user_mobile']->value;?>
' onblur="return verify_user_mobile()" />
        </div>
        <div id="user_mobile_msg"></div></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">性别：</td>
      <td align="left"><?php echo smarty_function_html_radios(array('name'=>"txt_user_sex",'options'=>$_smarty_tpl->tpl_vars['user_sex_options']->value,'checked'=>$_smarty_tpl->tpl_vars['user_sex_checked']->value,'separator'=>" "),$_smarty_tpl);?>
</td>
    </tr>
    <tr>
      <td align="right" class="navi_link">在线QQ：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="txt_user_qq" id="txt_user_qq" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_user_qq']->value;?>
' onblur="return verify_user_qq()" />
        </div>
        <div id="user_qq_msg"></div></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">生日：</td>
      <td align="left"><input type="text" name="txt_birthday" id="txt_birthday" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_birthday']->value;?>
' /></td>
    </tr>
  </table>
  <div class="step_title">通讯地址</div>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td align="right" class="navi_link">所在城市：</td>
      <td align="left"><select name="txt_area1" id="txt_area1">
        </select>
        省(直辖市)
        <input name="txt_province" id="txt_province" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['txt_province']->value;?>
" />
        <select name="txt_area2" id="txt_area2">
        </select>
        市(地区)
        <input name="txt_city" id="txt_city" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['txt_city']->value;?>
" />
        <select name="txt_area3" id="txt_area3">
        </select>
        区(县)
        <input name="txt_county" id="txt_county" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['txt_county']->value;?>
" /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">详细地址：</td>
      <td align="left"><input name="txt_address" type="text" class="stit" id="txt_address" value='<?php echo $_smarty_tpl->tpl_vars['txt_address']->value;?>
' size="50" /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">邮政编码：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="txt_zip_code" id="txt_zip_code" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_zip_code']->value;?>
' onblur="return verify_zip_code()" />
        </div>
        <div id="zip_code_msg"></div></td>
    </tr>
  </table>
  <div class="step_title">更多信息</div>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td align="right" class="navi_link">婚姻状况：</td>
      <td align="left"><?php echo smarty_function_html_radios(array('name'=>"txt_marital_status",'options'=>$_smarty_tpl->tpl_vars['marital_status_options']->value,'checked'=>$_smarty_tpl->tpl_vars['marital_status_checked']->value,'separator'=>" "),$_smarty_tpl);?>
</td>
    </tr>
    <tr>
      <td align="right" class="navi_link">从事职业：</td>
      <td align="left"><input type="text" name="txt_job" id="txt_job" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['txt_job']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">个人介绍：</td>
      <td align="left"><textarea id="txt_introduction" name="txt_introduction" rows="7" style="width: 60%"><?php echo $_smarty_tpl->tpl_vars['txt_introduction']->value;?>
</textarea></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">交友目的：</td>
      <td align="left"><?php echo smarty_function_html_checkboxes(array('name'=>"txt_looking_for",'options'=>$_smarty_tpl->tpl_vars['looking_for_options']->value,'checked'=>$_smarty_tpl->tpl_vars['looking_for_checked']->value,'separator'=>" "),$_smarty_tpl);?>
</td>
    </tr>
    <tr>
      <td align="right" class="navi_link">性 格：</td>
      <td align="left"><?php echo smarty_function_html_checkboxes(array('name'=>"txt_nature",'options'=>$_smarty_tpl->tpl_vars['nature_options']->value,'checked'=>$_smarty_tpl->tpl_vars['nature_checked']->value,'separator'=>" "),$_smarty_tpl);?>
</td>
    </tr>
    <tr>
      <td align="right" class="navi_link">兴趣爱好：</td>
      <td align="left"><input type="text" name="txt_interests" id="txt_interests" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_interests']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的音乐：</td>
      <td align="left"><input type="text" name="txt_favorite_music" id="txt_favorite_music" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_music']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的书籍：</td>
      <td align="left"><input type="text" name="txt_favorite_books" id="txt_favorite_books" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_books']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的电影：</td>
      <td align="left"><input type="text" name="txt_favorite_movies" id="txt_favorite_movies" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_movies']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的电视：</td>
      <td align="left"><input type="text" name="txt_favorite_tv" id="txt_favorite_tv" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_tv']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的游戏：</td>
      <td align="left"><input type="text" name="txt_favorite_game" id="txt_favorite_game" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_game']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的运动：</td>
      <td align="left"><input type="text" name="txt_favorite_sport" id="txt_favorite_sport" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_sport']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">喜欢的明星：</td>
      <td align="left"><input type="text" name="txt_favorite_star" id="txt_favorite_star" class="input1" value='<?php echo $_smarty_tpl->tpl_vars['txt_favorite_star']->value;?>
' /></td>
    </tr>
    <tr class="TR_BG_list">
      <td align="right" class="navi_link">&nbsp;</td>
      <td align="left"><input type="submit" name="button" id="button" value="提交" class="inputbg" onclick="return Result()" /></td>
    </tr>
  </table>
</form>

        
        </td>
      </tr>
    </table>
  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."my/myfooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html><?php }} ?>