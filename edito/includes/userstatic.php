<?php
//判断会员是否登陆
if(!empty($_COOKIE['user_auth'])) {
	list($m_uid, $m_username) = explode("\t", uc_authcode($_COOKIE['user_auth'], 'DECODE'));
} else {
	$m_uid ="0"; $m_username = '';
	header('Location:/my/login.php?url='.urlencode($_SERVER['REQUEST_URI']));
}