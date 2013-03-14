<?php
include '../init.php';
include ACTION_PATH.'Tmall_ordersAction.php';

$order=new Tmall_ordersAction();
$lifetime=3600;
	session_set_cookie_params($lifetime);
	session_start();
if (isset($_GET['p_num']) && isset($_GET['p_id']) && isset($_GET['m_id'])){
	
	$product_num=Common::isint($_GET['p_num']);//数量
	$product_id=Common::isint($_GET['p_id']);//商品ID
	$mall_id=Common::isint($_GET['m_id']);//商家ID
	$order=new Tmall_ordersAction();
	$order->addorder($product_id, $mall_id, $product_num);
	if (isset($_SESSION['order_item'])){
		echo "1";
	}else {
		echo "0";
	}
	exit(0);
}

if (isset($_GET['edit_num']) && isset($_GET['edit_id'])){
	$num=Common::isint($_GET['edit_num']);//数量
	$pid=Common::isint($_GET['edit_id']);//商品ID
	$order->edit_order_num($pid, $num);
	exit(0);
}

if (isset($_GET['act']) && $_GET['act']=="delete_order" && isset($_GET['id'])){
	$id=Common::isint($_GET['id']);
	echo $order->delete_order($id);
	exit(0);
}

if (isset($_GET['act']) && $_GET['act']=="add"){
	include_once ACTION_PATH.'/Member_addressAction.php';
	$addr=new Member_addressAction();
	$m_uid=8;
	echo $addr->add($m_uid);
}