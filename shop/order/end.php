<?php
include dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';

$order=new model('orders');
$order_num=C::get('order_num');
if (!empty($order_num)){	
	$field='uid,total_money,pay_ment';
	$row=$order->where("order_num='$order_num'")->find($field);

	$user_id=$row[0];
	$oitem=new model('order_item');
	$special=$oitem->where("order_num='$order_num'")->getField('sum(special_price)');
	$a=$sing->where('id='.$_CFG['display'][5])->getField('content');
	$smarty->assign("order_num",$order_num);
	$smarty->assign("price",($row[1]-$special));
	$smarty->assign("payment",$row[2]);
	$smarty->assign('bankmsg',$a);
}
$smarty->display(DEFAUTL_PATH."shop/order_end.htm");