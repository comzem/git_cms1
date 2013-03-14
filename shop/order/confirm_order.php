<?php
include dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';
if (empty($uid)){
	C::msg('', '/shop/order/cart.php');
}
include ACTION_PATH.'orders.php';
$order=new orders();
$addr=new model('member_address');
$field='id,cname,province,city,county,address,zip,tel,mobile,email,tel_code,default_addr';
$addr_data=$addr->where('uid='.$uid)->select($field);
include ACTION_PATH.'tools.php';
$tools=new tools();
$data=array(
		'addr'=>$addr_data,
		'order_addr'=>$addr->where("default_addr='Y' and uid=".$uid)->getField('id'),
		'province_options'=>$tools->area(),
		'province'=>'',
		'city_options'=>'请选择市...',
		'city'=>'',
		'county_options'=>'请选择区/县...',
		'county'=>'',
		'order_num'=>$_SESSION['order_num'],
		'pay_ment_options'=>array("网上支付"=>"网上支付","银行汇款"=>"银行汇款","货到付款"=>"货到付款","款到发货"=>"款到发货"),
		'pay_ment_checked'=>'网上支付',
		'money'=>$order->get_money(),
		'list'=>$order->orderitem()
);

/** * 添加订单 */
$order_num=$_SESSION['order_num'];//订单号
if (isset($_GET['act']) && $_GET['act']=="add"){
	//收货地址ID
	$addr_id=$_POST['order_addr'];
	if (isset($addr_id) && !empty($addr_id)){
		$addr=new model('member_address');
		//返回收货地址
		$addr_field='cname,province,city,county,address,tel_code,tel,mobile,email,zip';
		$addr_array=$addr->where('id='.$addr_id)->find($addr_field);
		//添加订单
		$order->add($uid,$order_num,$addr_array);
		//返回订单详细信息
		$order_item=$order->orderitem();
		//添加订单详细信息
		$order->additem($order_num,$order_item);
		C::msg('', 'end.php?order_num='.$order_num);
		unset($_SESSION['order_item']);
		unset($_SESSION['order_num']);
	}else {
		C::msg('请填写收货地址！', '-1');
	}
}

$smarty->assign($data);
$smarty->display(DEFAUTL_PATH."shop/order_confirm.htm");