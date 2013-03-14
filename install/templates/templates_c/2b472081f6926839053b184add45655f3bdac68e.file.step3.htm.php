<?php /* Smarty version Smarty-3.1.11, created on 2013-03-04 14:28:51
         compiled from "F:\cms\install\templates\step3.htm" */ ?>
<?php /*%%SmartyHeaderCode:9941512c691bb91dd2-56377389%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b472081f6926839053b184add45655f3bdac68e' => 
    array (
      0 => 'F:\\cms\\install\\templates\\step3.htm',
      1 => 1362378530,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9941512c691bb91dd2-56377389',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_512c691bc612a0_59760106',
  'variables' => 
  array (
    'path' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512c691bc612a0_59760106')) {function content_512c691bc612a0_59760106($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安装向导</title>
<link href="templates/css/common.css" rel="stylesheet" type="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<script language="javascript" type="text/javascript" src="templates/js/openlayer.js"></script>
<script language="javascript" type="text/javascript" src="templates/js/jquery.js"></script>
</head>

<body>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:8px;">
  <tr>
    <td width="186" valign="top"><table width="180" border="0" cellspacing="0" cellpadding="0"  class="left_table_right_dot">
      <tr>
        <td>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
	
		</td>
      </tr>
    </table></td>
    <td valign="top">
	 <form action="index.php?step=4" method="post">
	<table width="98%" border="0" align="center" cellpadding="6" cellspacing="0">
      <tr>
        <td bgcolor="#F7FBFC" style=" font-size:13px; padding-left:15px;  "> <strong>数据库配置</strong> </td>
      </tr>
      <tr>
        <td style="line-height:200%;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="17%" align="right">数据库主机：</td>
            <td width="83%"><input name="dbhost" type="text" id="dbhost" value="localhost"  class="step_text" /></td>
          </tr>
          <tr>
            <td align="right">数据库用户名：</td>
            <td><input name="dbuser" type="text" id="dbuser"  class="step_text" /></td>
          </tr>
          <tr>
            <td align="right">数据库密码：</td>
            <td><input name="dbpass" type="text" id="dbpass"  class="step_text" /></td>
          </tr>
		            <tr>
            <td align="right">数据库名称：</td>
            <td><input name="dbname" type="text" id="dbname"  class="step_text" /></td>
          </tr>
          <tr>
            <td align="right">数据表前缀：</td>
            <td><input name="pre" type="text"  class="step_text" id="pre" value="cms_" /></td>
          </tr>
        </table></td>
      </tr>
    </table>
    <table width="98%" border="0" align="center" cellpadding="6" cellspacing="0">
      <tr>
        <td bgcolor="#F7FBFC" style=" font-size:13px; padding-left:15px;  "> <strong>网站配置</strong> </td>
      </tr>
      <tr>
        <td style="line-height:200%;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="17%" align="right">绑定域名：</td>
            <td width="83%"><input name="doname" type="text" id="doname"  class="step_text" /> 多个域名用半角逗号隔开</td>
          </tr>
          <tr>
            <td align="right">key：</td>
            <td><input name="key" type="text" id="key"  class="step_text" /></td>
          </tr>

        </table></td>
      </tr>
    </table>
      <table width="98%" border="0" align="center" cellpadding="6" cellspacing="0">
        <tr>
          <td bgcolor="#F7FBFC" style=" font-size:13px; padding-left:15px;  "><strong>管理员账号</strong> </td>
        </tr>
        <tr>
          <td style="line-height:200%;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="17%" align="right">管理员姓名：</td>
              <td width="83%"><input name="admin_name" type="text" id="admin_name"  class="step_text" /></td>
            </tr>
            <tr>
              <td align="right">登录密码：</td>
              <td><input name="admin_pwd" type="password" id="admin_pwd"  class="step_text" /></td>
            </tr>
            <tr>
              <td align="right">密码确认：</td>
              <td><input name="admin_pwd1" type="password" id="admin_pwd1"  class="step_text" /></td>
            </tr>
            <tr>
              <td align="right">电子邮箱：</td>
              <td><input name="admin_email" type="text" id="admin_email"  class="step_text" /></td>
            </tr>

          </table>
          </td>
        </tr>
        <tr>
          <td height="55" align="center"  >
	<input name="" type="button"  class="step_submit" onclick="window.location.href='index.php?step=2';" value="上一步" />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="submit" name="" value="下一步"  class="step_submit"  onclick="openLayer('op1','tis');"/>
		 
		  </td>
        </tr>
      </table>
	   </form></td>
  </tr>
</table>
  <!--弹出层的内容-->
<span id="op1"></span>
<div id="tis" style="display: none" >
<div style="width:350px; height:40px; font-size:12px; background-color: #FFFFFF; text-align:center; padding:20px; color:#003399">
<img src="templates/images/loading.gif" /><br /><br />
正在安装。请不要关闭窗口。
</div>
</div>
<!--弹出层的内容结束-->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."foot.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html>
<?php }} ?>