<?php
class admincp{
	public $method;
	function init($smarty){
		//if (C::get('operation')!='login_index' && C::get('operation')!='login'){
			if (!isset($_SESSION['auth_admin']) && empty($_SESSION['auth_admin'])){
				$this->login_index();
				$this->do_user_login();
			}else{
				list($uid, $username,$gid) = explode('\t', C::_authcode($_SESSION['auth_admin'],'DECODE'));
				if ($uid>0){
					if ($gid=='3'){
						C::msg('不存在此管理员！', '/');
						exit(0);
					}
				}
				$this->run();
				$smarty->assign('username',$username);
				if (C::get('action')===null){
					$this->admin_main($smarty);
				}
			}
		//}
	}
	
	function login_index(){
		require ACTION_PATH.'members.php';
		$members=new members();
		$members->login_index();
	}
	
	function do_user_login(){
		if (empty($_POST)){
			return false;
		}
		//require ACTION_PATH.'members.php';
		$members=new members();
		$login=$members->login();
		list($uid,$username,$gid)=$login;
		if ($uid>0 && $gid=='3'){
			C::msg($gid.'不存在此管理员', '-1');
			return false;
		}		
		if ($uid>0){
			$_SESSION['auth_admin']=C::_authcode(implode('\t', $login));
			C::msg('', '?');
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
	
	function do_admin_logout(){
		unset($_SESSION['auth_admin']);
		$this->login_index();
		C::msg('', '?');
		exit(0);
	}
	
	function admin_main($smarty){
		if (isset($_SESSION['auth_admin']))
			$smarty->display(DEFAUTL_PATH.'index.htm');
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