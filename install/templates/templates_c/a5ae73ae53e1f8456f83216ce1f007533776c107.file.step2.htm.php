<?php /* Smarty version Smarty-3.1.11, created on 2013-03-13 19:10:23
         compiled from "E:\cms\install\templates\step2.htm" */ ?>
<?php /*%%SmartyHeaderCode:3089851405e9fb06519-13523630%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5ae73ae53e1f8456f83216ce1f007533776c107' => 
    array (
      0 => 'E:\\cms\\install\\templates\\step2.htm',
      1 => 1362378321,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3089851405e9fb06519-13523630',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'path' => 0,
    'system_info' => 0,
    'dir_check' => 0,
    'next' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_51405e9fc893b0_14616830',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51405e9fc893b0_14616830')) {function content_51405e9fc893b0_14616830($_smarty_tpl) {?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/css/common.css" rel="stylesheet" type="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
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
        <td bgcolor="#F7FBFC" style=" font-size:13px; padding-left:15px;  "> <strong>服务器信息</strong> </td>
      </tr>
      <tr>
        <td style="line-height:200%;">
		服务器操作系统：<span style="color:#0066CC"><?php echo $_smarty_tpl->tpl_vars['system_info']->value['os'];?>
</span><br />
服务器解译引擎：<span style="color:#0066CC"><?php echo $_smarty_tpl->tpl_vars['system_info']->value['web_server'];?>
</span><br />
PHP版本：<span style="color:#0066CC"><?php echo $_smarty_tpl->tpl_vars['system_info']->value['php_ver'];?>
</span><br />
上传附件最大值：<span style="color:#0066CC"><?php echo $_smarty_tpl->tpl_vars['system_info']->value['max_filesize'];?>
</span>
</td>
      </tr>
    </table>
      <table width="98%" border="0" align="center" cellpadding="6" cellspacing="0">
        <tr>
          <td bgcolor="#F7FBFC" style=" font-size:13px; padding-left:15px;  "><strong>目录权限检测</strong> </td>
        </tr>
        <tr>
          <td style="line-height:200%;"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td width="33%" align="center"><strong>目录名</strong></td>
              <td width="33%" align="center"><strong>读取权限</strong></td>
              <td align="center"><strong>写入权限</strong></td>
            </tr>
          	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['dir'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['name'] = 'dir';
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['dir_check']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['dir']['total']);
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['dir_check']->value[$_smarty_tpl->getVariable('smarty')->value['section']['dir']['index']]['dir'];?>
</td>
				<td align="center"><?php echo $_smarty_tpl->tpl_vars['dir_check']->value[$_smarty_tpl->getVariable('smarty')->value['section']['dir']['index']]['read'];?>
</td>
				<td align="center"><?php echo $_smarty_tpl->tpl_vars['dir_check']->value[$_smarty_tpl->getVariable('smarty')->value['section']['dir']['index']]['write'];?>
</td>
			</tr>
			<?php endfor; endif; ?>
          </table>          </td>
        </tr>
        <tr>
          <td height="55" align="center"  >
		  <form action="index.php" method="get">
	<input name="step" type="hidden" value="3" />
	<input name="" type="button"  class="step_submit" onclick="window.location.href='index.php?step=1';" value="上一步" />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <?php if ($_smarty_tpl->tpl_vars['next']->value==1){?>
        <input type="submit" name="" value="下一步"  class="step_submit" />
      <?php }else{ ?>
      	<input type="button" value="请检查目录权限..." class="step_submit" disabled="disabled" />
      <?php }?>
		  </form>
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['path']->value)."foot.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html>
<?php }} ?>