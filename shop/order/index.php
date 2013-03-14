<?php
include dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';

if (isset($_POST['product_num']) && isset($_POST['product_id'])){
	$_SESSION['order_num']=strtotime('now')+mt_rand(1000, 9999);
	$product_num=C::isint($_POST['product_num']);//数量
	$product_id=C::isint($_POST['product_id']);//商品ID
	$pro=C::get('proinput');
	$property=(get('property')===null)?'':get('property');
	if (!empty($pro)){
		$pro=explode(',', $pro);
		foreach ($pro as $row){
			$property.=','.get($row);
		}
		$property=substr($property, 1);
	}
	include ACTION_PATH.'orders.php';
	$order=new orders();
	$order->addorder($product_id, $product_num,$property);	
	
	header("Location:cart.php");
}
