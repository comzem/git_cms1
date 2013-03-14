<?php
class memberscp{
	public $method;
	
	function init($smarty){
		if(!empty($_SESSION['auth_user'])) {
			list($uid,$username,$gid)=explode('\t', C::_authcode($_SESSION['auth_user'],'DECODE'));
			if (C::get('action')===null){
				$smarty->display(DEFAUTL_PATH.'uindex.htm');
			}
			$this->run($smarty);
		} else {
			$uid = $username = '';
			C::msg('', 'login.php');
		}
	}
	
	function user_login(){
		require ACTION_PATH.'members.php';
		$members=new members();
		$login=$members->login();
		list($uid,$username,$gid)=$login;
		$url=C::get('backurl');
		if ($uid>0){
			if (!empty($url)){
				C::msg('', $url);
			}else{
				C::msg('', '/my/');
			}
		}else{
			switch ($uid){
				case '-1':
					C::msg('账号不存在', '-1');
					break;
				case '-2':
					C::msg('密码错', '-1');
					break;
			}
		}		
	}
	
	/**
	 * 应用程序初始化，加载类，
	 * Enter description here ...
	 */
	public function run($parm=null){
		$action=C::get('action');//判断哪一个model 如members
		$operation=C::get('operation');//判断哪一个操作
		if ($action===null){
			return false;
		}
		//判断是否加载指定的操作类action
		if (in_array($action, $this->method)){
			if (file_exists(ACTION_PATH.$action.'.php')){
				include ACTION_PATH.$action.'.php';
			}else{
				exit('file not found!');
			}
		}else{
			exit('action not found!');
		}
		$control=new $action();
		$method=$operation;
		//判断方法是否存在且不是私有方法
		if (method_exists($control, $method) && $operation{0}!='_'){
			if ($parm!=null)
				$data=$control->$method($parm);
			else
				$data=$control->$method();
		}else{
			exit('method not found!');
		}
	}
}