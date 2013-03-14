<?php /* Smarty version Smarty-3.1.11, created on 2013-02-11 16:00:36
         compiled from "E:\cms\template\default\address_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:281855118a524a75849-06412937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5f6493c3ae22348d4082fca8813d1e57af20967' => 
    array (
      0 => 'E:\\cms\\template\\default\\address_list.htm',
      1 => 1360317958,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '281855118a524a75849-06412937',
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
    'list' => 0,
    'paging' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5118a524b84fc1_86878505',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5118a524b84fc1_86878505')) {function content_5118a524b84fc1_86878505($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
        
        
<div class="all_list">
  <div class="list_move"><a href='?action=members&operation=addrview'>添加收货地址</a></div>
  <div class="list_out">管理收货地址</div>
</div>
<form id="form1" name="form1" method="post" action="?act=<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
">
  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="table bor1">
    <tr class="nav_tit">
      <th style="width:30px;"><input id="chkAll" type="checkbox" onclick="checkAll('gcheck')" /></th>
      <th>收货人</th>
      <th>所在地区</th>
      <th>街道地址</th>
      <th>邮编</th>
      <th>电话/手机</th>
      <th> </th>
      <th>操作</th>
    </tr>
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>
    <tr onmouseover="c=this.style.backgroundColor;this.style.backgroundColor='#f4f4f4';" onmouseout="this.style.backgroundColor=c;">
      <td><input type="checkbox" name="check_id[]" id="gcheck" value='<?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
'></td>
      <td><?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['cname'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['area1'];?>
 <?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['area2'];?>
 <?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['area3'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['address'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['zip'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['tel_code'];?>
-<?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['tel'];?>
<br />
        <?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['mobile'];?>
</td>
      <td><?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['default_addr']=="Y"){?>默认地址<?php }?></td>
      <td><a href="?filename=myaddress&act=display2&id=<?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
">修改</a> <a href="#" onclick="return getDel(this,'<?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
','')">删除</a></td>
    </tr>
    <?php endfor; else: ?>
    没有数据...
    <?php endif; ?>
    <tr>
      <td colspan="10"><input type="submit" value="删除" name="Button1" onclick="return del_check(this.form,'member_address.php')" />
        <?php echo $_smarty_tpl->tpl_vars['paging']->value;?>
</td>
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