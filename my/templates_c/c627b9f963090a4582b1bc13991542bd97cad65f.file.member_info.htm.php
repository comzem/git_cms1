<?php /* Smarty version Smarty-3.1.11, created on 2013-03-04 00:08:53
         compiled from "E:\cms\template\default\member_info.htm" */ ?>
<?php /*%%SmartyHeaderCode:1785651336ed62bcdc2-66287556%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c627b9f963090a4582b1bc13991542bd97cad65f' => 
    array (
      0 => 'E:\\cms\\template\\default\\member_info.htm',
      1 => 1362326867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1785651336ed62bcdc2-66287556',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_51336ed6435113_14419522',
  'variables' => 
  array (
    'keywords' => 0,
    'tpl' => 0,
    'path' => 0,
    'tab' => 0,
    'gid_options' => 0,
    'gid' => 0,
    'username' => 0,
    'nickname' => 0,
    'password' => 0,
    'email' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51336ed6435113_14419522')) {function content_51336ed6435113_14419522($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'E:\\cms\\Smarty\\plugins\\function.html_options.php';
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
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body style="background:url(/images/user/head_basic.jpg) no-repeat top center;">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."my/myheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="bor1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="left" valign="top"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."my/menu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 </td>
      <td class="right" valign="top"><form id="form1" action="<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
" method="post" name="form1">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td align="right" class="navi_link">用户组：</td>
      <td align="left">
      <select name="gid"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['gid_options']->value,'selected'=>$_smarty_tpl->tpl_vars['gid']->value),$_smarty_tpl);?>
</select>
      </td>
    </tr>
    <tr>
      <td align="right" class="navi_link">*帐号：</td>
      <td align="left">
      <div class="input_left">
      <input type="text" name="username" id="username" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
' onblur="return verify_user_name()" />
        </div>
        <div id="user_name_msg"></div>
      </td>
    </tr>
    <tr>
      <td align="right" class="navi_link"> 昵称：</td>
      <td align="left">
          <input type="text" name="nickname" id="nickname" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
' onblur="return verify_nick_name()" /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">密码：</td>
      <td align="left"><input type="text" name="password" id="password" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
' /></td>
    </tr>
    <tr>
      <td align="right" class="navi_link">* Email：</td>
      <td align="left"><div class="input_left">
          <input type="text" name="email" id="email" class="stit" value='<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
' onblur="return verify_email()" />
        </div>
        <div id="email_msg"></div></td>
    </tr>

  </table>
  <div class="nav_bg">选填</div>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">    
    <tr class="TR_BG_list">
      <td align="right" class="navi_link">&nbsp;</td>
      <td align="left"><input type="submit" name="button" id="button" value="提交" class="admin_submit" onclick="return Result()" /></td>
    </tr>
  </table>
</form></td>
    </tr>
  </table>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."my/myfooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html><?php }} ?>