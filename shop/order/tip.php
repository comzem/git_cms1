<?php 
include dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';
include ACTION_PATH.'orders.php';
$order=new orders();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示页面</title>
<link type="text/css" rel="stylesheet" href="<?php echo $site[1],'/'.$tmp_path;?>/css/style.css" />
</head>

<body style="padding:15px;">
<div class="tip">
<b>添加成功！</b><br/>
购物车共有<b><?php echo count($_SESSION['order_item']);?></b>种宝贝，合计：¥<span><?php echo $order->get_money();?></span>
</div>
<table>
	<tr>
	<td><a href="/shop/order/cart.php" target="_parent" class="tipbtn">去购物车结算</a></td>
	<td><a href="/shop/search_product.php" target="_parent" class="tipbtn">继续购买</a></td></tr>
</table>
</body>
</html>