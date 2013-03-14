<?php /* Smarty version Smarty-3.1.11, created on 2013-03-13 19:13:29
         compiled from "E:\cms\install\templates\step4.htm" */ ?>
<?php /*%%SmartyHeaderCode:1314651405f591a1c82-06505452%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66596da780039f1f01b063ab54d7378b426a1370' => 
    array (
      0 => 'E:\\cms\\install\\templates\\step4.htm',
      1 => 1361871088,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1314651405f591a1c82-06505452',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'path' => 0,
    'msg' => 0,
    'show' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_51405f5925dab3_74123936',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51405f5925dab3_74123936')) {function content_51405f5925dab3_74123936($_smarty_tpl) {?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/css/common.css" rel="stylesheet" type="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<script language="javascript" type="text/javascript" src="templates/js/jquery.js"></script>
<title>安装向导</title>
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
    <td valign="top"><table width="98%" border="0" align="center" cellpadding="6" cellspacing="0">
      <tr>
        <td bgcolor="#F7FBFC" style=" font-size:13px; padding-left:15px; "><strong>安装完成</strong> </td>
      </tr>
      <tr>
        <td style="line-height:200%;"><table width="100%" border="0" cellspacing="15" cellpadding="0">
          <tr>
            <td align="center"><strong style="color:#009900; font-size:14px;"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</strong></td>
          </tr>
          <tr>
            <td align="center"><table width="250" border="0" cellspacing="15" cellpadding="0" <?php echo $_smarty_tpl->tpl_vars['show']->value;?>
>
                <tr>
                  <td height="30" align="center" bgcolor="#EAF5F7"><a href="../" target="_blank">网站首页</a></td>
                  <td align="center" bgcolor="#EAF5F7"><a href="../admin.php" target="_blank">网站后台</a></td>
                </tr>
              </table>
             </td>
          </tr>
        </table></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."foot.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html>
<?php }} ?>