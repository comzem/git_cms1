<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
require FUNC_PATH.'memberscp.php';
$smarty->assign('uid',$uid);
$memberscp=new memberscp();
$memberscp->method=array(
				'news',
				'single',
				'photos',
				'product',
				'orders',
				'down',
				'video',
				'job',
				'recruitment',
				'guest',
				'tools',
				'members',
				'sysconfig',
				'links',
				'ad');
$memberscp->init($smarty);