<?php /* Smarty version Smarty-3.1.11, created on 2013-03-04 00:07:29
         compiled from "E:\cms\template\default\my\menu.htm" */ ?>
<?php /*%%SmartyHeaderCode:2040951337541e2f556-10213960%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7cfa981e34ec04fc7ab11383292736317bf7070' => 
    array (
      0 => 'E:\\cms\\template\\default\\my\\menu.htm',
      1 => 1362325233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2040951337541e2f556-10213960',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_51337541e31b91_05630130',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51337541e31b91_05630130')) {function content_51337541e31b91_05630130($_smarty_tpl) {?><div class="sjleft">
  <div class="sjtouxiang"> <a href="#" target="_blank"><img title="" src="/upload/user.jpg" border="0" /> </a> </div>
  <ul class="gnul">
    <li><a href="?action=members&operation=view">编辑资料</a></li>
  </ul>
  <div style="margin-top:15px; font-size:14px; font-weight:bold;">我的交易</div>
  <ul class="gnul">
    <!--<li><a href="?action=members&operation=fav">我的收藏</a></li>-->
    <li><a href="/shop/order/cart.php" target="_blank">我的购物车</a></li>
    <li><a href="?action=orders&operation=getlist">订单管理</a></li>
    <li><a href="?action=members&operation=getaddr">收货地址管理</a></li>
    <!--<li><a href="#">我的积分</a></li>-->
  </ul>
</div>
<?php }} ?>