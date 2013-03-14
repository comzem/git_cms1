<?php /* Smarty version Smarty-3.1.11, created on 2013-03-04 00:07:29
         compiled from "E:\cms\template\default\my\myheader.htm" */ ?>
<?php /*%%SmartyHeaderCode:2803251337541e02232-04464013%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0378d27e3a9277af4a483b3dfa0a136f1f271206' => 
    array (
      0 => 'E:\\cms\\template\\default\\my\\myheader.htm',
      1 => 1360752864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2803251337541e02232-04464013',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'username' => 0,
    'webname' => 0,
    'domain' => 0,
    'tpl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_51337541e1cae3_73152858',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51337541e1cae3_73152858')) {function content_51337541e1cae3_73152858($_smarty_tpl) {?>
<script>
	$(function(){
		$("#cnum").load("/inc/ajax.php?t=cnum&tm="+(new Date).getTime());
	})
</script>

<div class="quick_menu">
  <p> 您好，<span class="cred"><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</span>! 欢迎来到<?php echo $_smarty_tpl->tpl_vars['webname']->value;?>
！ <a href="/my/" title="会员中心">会员中心</a> <a href="/shop/order/cart.php" title="购物车">购物车 <span class="cred" id="cnum">0</span> 件</a> <a href="/inc/ajax.php?t=logout" title="退出" style="border:0">退出</a> </p>
</div>
<div class="bodyw"> <a href="/"><img src="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
<?php echo $_smarty_tpl->tpl_vars['tpl']->value;?>
/images/logo.gif" /></a><?php }} ?>