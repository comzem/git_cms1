<?php
//前端初始化配置
require dirname(dirname(__FILE__)).'/inc/constant.php';

//获取模板
$tmp=new model('template');
$tmp_path=$tmp->where("`default`='Y'")->getField('directory');
define('DEFAUTL_PATH', ROOT_PATH.$tmp_path.DIRECTORY_SEPARATOR);
$lifetime=3600;
session_set_cookie_params($lifetime);
session_start();
$uid=0;
$username='游客';
if (isset($_SESSION['auth_user'])){
	list($uid,$username,$gid)=explode('\t', C::_authcode($_SESSION['auth_user'],'DECODE'));
}
require FUNC_PATH.'global.fun.php';