<?php /* Smarty version Smarty-3.1.11, created on 2013-02-26 15:38:20
         compiled from "F:\cms\install\templates\left.htm" */ ?>
<?php /*%%SmartyHeaderCode:4031512c663518b389-10882240%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3111dd93930e282be6f86533760a762effa85d4b' => 
    array (
      0 => 'F:\\cms\\install\\templates\\left.htm',
      1 => 1361864281,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4031512c663518b389-10882240',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_512c6635217519_65764633',
  'variables' => 
  array (
    'act' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512c6635217519_65764633')) {function content_512c6635217519_65764633($_smarty_tpl) {?>﻿<table width="100%" border="0" cellspacing="0" cellpadding="0">
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