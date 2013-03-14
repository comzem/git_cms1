<?php
require dirname(dirname(__FILE__)).'/inc/init_cms.php';
require FUNC_PATH.'memberscp.php';
$memberscp=new memberscp();
$act=C::get('act');
if (isset($act) && $act=='login'){
	$memberscp->user_login();
}
$data=array(
		'msg'=>'',
		'seotitle'=>'会员登陆'
		);
$smarty->assign($data);
$smarty->display(DEFAUTL_PATH.'my/login.htm');
