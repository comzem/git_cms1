<?php
include dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';
include ACTION_PATH.'orders.php';
$order=new orders();
$d1="";$d2="style='display:none;'";
if (empty($_SESSION['order_item'])){
	$d1="style='display:none;'";
	$d2="";
}

$data=array(
		'd1'=>$d1,
		'd2'=>$d2,
		'order_num'=>isset($_SESSION['order_num'])?$_SESSION['order_num']:'',
		'money'=>$order->get_money(),
		'list'=>$order->orderitem(),
		'path'=>DEFAUTL_PATH);

$smarty->assign($data);
$smarty->display(DEFAUTL_PATH."shop/order_begin.htm");