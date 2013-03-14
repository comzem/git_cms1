<?php
include dirname(__FILE__).'/inc/init_admin.php';
session_start();
require FUNC_PATH.'admincp.php';
$admincp=new admincp();
$admincp->method=array(
			'news','single',
			'photos','product',
			'orders','down',
			'video','job',
			'recruitment','guest',
			'tools','members',
			'sysconfig','links',
			'ad','forum',
			'attachment'
		);

if (C::get('action')=='logout'){
	$admincp->do_admin_logout();
}elseif (C::get('action')=='login'){
	$admincp->do_user_login();
}

$admincp->init($smarty);