<?php
require dirname(dirname(__FILE__)).'/inc/init_cms.php';
if ($_CFG['register'][0]=='0'){
	die($_CFG['register'][1]);
}
$no_name=explode("\n", $_CFG['register'][2]);
$data=array(
		'msg'=>'',
		'seotitle'=>'会员注册');
$smarty->assign($data);
$act=C::get('act');
//会员注册
if (isset($act) && $act=='register'){
	require ACTION_PATH.'members.php';
	$user=new members();
	if (in_array(get('username'), $no_name)){
		msg('用户名已存在！', '-1');
		exit(0);
	}
	if (strlen(get('password'))<$_CFG['register'][3]){
		msg('密码长度不小于'.strlen(get('password')).','.$_CFG['register'][3].'位', '-1');
		exit(0);
	}
	if (!isset($_SESSION["code"]) || $_SESSION["code"]!=get('verifycode') || get('verifycode')===null){
		msg('验证码错误', '-1');
		exit(0);
	}
	$user->save();
}
$smarty->display(DEFAUTL_PATH."my/reg.htm");