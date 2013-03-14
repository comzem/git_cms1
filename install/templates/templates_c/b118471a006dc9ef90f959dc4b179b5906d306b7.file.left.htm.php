<?php /* Smarty version Smarty-3.1.11, created on 2013-03-03 21:31:33
         compiled from "E:\cms\install\templates\left.htm" */ ?>
<?php /*%%SmartyHeaderCode:12571513350b58f4a98-57428888%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b118471a006dc9ef90f959dc4b179b5906d306b7' => 
    array (
      0 => 'E:\\cms\\install\\templates\\left.htm',
      1 => 1361864281,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12571513350b58f4a98-57428888',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'act' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_513350b59a8922_83044897',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_513350b59a8922_83044897')) {function content_513350b59a8922_83044897($_smarty_tpl) {?>﻿<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if ($_smarty_tpl->tpl_vars['act']->value=="1"){?>
<tr>
<td height="40" align="center" class="link_1">许可协议</td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['act']->value>1){?>
<tr>
<td height="40" align="center" class="link_2">许可协议</td>
</tr>
<?php }else{ ?>
<tr>
<td height="40" align="center" >许可协议</td>
</tr>
<?php }?>
<!-- -->
<?php if ($_smarty_tpl->tpl_vars['act']->value=="2"){?>
<tr>
<td height="40" align="center" class="link_1">环境检测</td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['act']->value>2){?>
<tr>
<td height="40" align="center" class="link_2">环境检测</td>
</tr>
<?php }else{ ?>
<tr>
<td height="40" align="center" >环境检测</td>
</tr>
<?php }?>
<!-- -->
<?php if ($_smarty_tpl->tpl_vars['act']->value=="3"){?>
<tr>
<td height="40" align="center" class="link_1">参数配置</td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['act']->value>3){?>
<tr>
<td height="40" align="center" class="link_2">参数配置</td>
</tr>
<?php }else{ ?>
<tr>
<td height="40" align="center" >参数配置</td>
</tr>
<?php }?>
<tr>
<td height="40" align="center">开始安装</td>
</tr>
<!-- -->
<?php if ($_smarty_tpl->tpl_vars['act']->value=="4"){?>
<tr>
<td height="40" align="center" class="link_1">安装完成</td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['act']->value>4){?>
<tr>
<td height="40" align="center" class="link_2">安装完成</td>
</tr>
<?php }else{ ?>
<tr>
<td height="40" align="center" >安装完成</td>
</tr>
<?php }?>
</table><?php }} ?>