<?php
include dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';

$tenpay_set=$_CFG['tenpay'];
$spname="";
$partner = $tenpay_set[0];                                  	//财付通商户号
$key = $tenpay_set[1];									//财付通密钥

$return_url = $site[1]."/shop/tenpay/payReturnUrl.php";			//显示支付结果页面,*替换成payReturnUrl.php所在路径
$notify_url = $site[1]."/shop/tenpay/payNotifyUrl.php";			//支付完成后的回调处理页面,*替换成payNotifyUrl.php所在路径
?>