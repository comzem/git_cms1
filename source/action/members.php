<?php
class members {
	protected $where='',$order='';
	function __construct() {
	}

	/**
	 * 添加
	 */
	public function save() {
		$pw=C::get('password');
		if (!empty($pw)){
			$pw=sha1(C::get('password'));
		}
		$username=get('username');
		$email=get('email');
		$user=new model('members');		
		$data_1 = array (
				"gid"=>C::get('gid'),
				"username"=>C::LeftStr($username,15),
				"nickname"=>C::LeftStr(C::get('nickname'),20),
				"password"=>$pw,
				"email"=>C::LeftStr($email,40),
				"regdate"=>time(),
				//"regip"=>C::ip(),
				'readname'=>C::LeftStr(get('readname'),15),
				'sex'=>get('sex'),
				'birth'=>get('birth'),
				'province'=>get('province'),
				'city'=>get('city'),
				'address'=>C::LeftStr(get('address'),255),
				'mobile'=>C::LeftStr(get('mobile'),11),
				'tel'=>C::LeftStr(get('tel'),13),
				'qq'=>C::isint(get('qq'))
		);
		//属性
		$data_2=array();		
		$id=C::get('id');
		if (!empty($id)){
			$user->data($data_1)->where('uid='.$id)->save();
		}else{
			if ($user->where("username='$username' or email='$email'")->getField('count(uid)')>0){
				msg('用户名或邮箱已存在，请重新填写？', '-1');
				exit(0);
			}
			if (!isset($_SESSION['user_time'])){
				$_SESSION['user_time']=time();
				$uid=$user->data($data_1)->add();
			}else{
				global $_CFG;
				if (time()-$_SESSION['user_time']<$_CFG['register'][5]*60){
					echo -2;
					exit(0);
				}else{
					$_SESSION['user_time']=time();
					$uid=$user->data($data_1)->add();
				}
			}
			if ($uid>0){				
				msg('', '/source/redirect.php?msg=会员注册成功&url='.urlencode('/my/'));
			}
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	/*************地址***************/
	public function saveaddr(){
		if (isset($_SESSION['auth_user'])){
			list($uid,$username,$gid)=explode('\t', C::_authcode($_SESSION['auth_user'],'DECODE'));
		}else{
			return false;
		}
		
		$data=array(
				"cname"=>C::LeftStr(C::get('cname'),10),
				"province"=>C::get('province'),
				"city"=>C::get('city'),
				"county"=>C::get('county'),
				"address"=>C::LeftStr(C::get('address'),50),
				"zip"=>C::LeftStr(C::get('zip'),6),
				"tel_code"=>C::LeftStr(C::get('tel_code'),4),
				"tel"=>C::LeftStr(C::get('tel'),16),
				"mobile"=>C::LeftStr(C::get('mobile'),15),
				"email"=>C::LeftStr(C::get('email'),50),
				"default_addr"=>C::get('default_addr'),
				"uid"=>$uid,
				"add_time"=>time(),
				"ip"=>C::GetIp()
		);
		$adr=new model('member_address');
		if (C::get('default_addr')=='Y'){
			$adr->where("default_addr='Y'")->setField("default_addr='N'");
		}
		if (isset($_GET['id'])){
			$id=C::get('id');
			$adr->where('id='.$id)->data($data)->save();
		}else{			
			$id=$adr->data($data)->add();
		}
		
		if (isset($_POST['type'])){
			C::msg('', '?action=members&operation=getaddr');
		}else{
			return $id;
		}
		
	}

	public function getaddr($smarty){
		if (isset($_SESSION['auth_user'])){
			list($uid,$username,$gid)=explode('\t', C::_authcode($_SESSION['auth_user'],'DECODE'));
		}else{
			return false;
		}
		$adr=new model('member_address');
		$field='id,cname,province,city,county,address,tel_code,tel,mobile,email,zip,default_addr';
		$url='';		
		//$smarty=new Smarty();
		$arr=$adr->where('uid='.$uid)->select($field);

		$data=array(
				'tab'=>'?action=members&operation=addrdel',
				'list'=>$arr,
				'paging'=>'',);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'my/address_list.htm');
	}
	
	public function addrview($smarty){
		$field='cname,province,city,county,address,tel_code,tel,mobile,email,zip,default_addr';
		$id=C::get('id');
		$gdata=array();
		if (!empty($id)){
			$adr=new model('member_address');
			$data=$adr->where('id='.$id)->select($field);
			$data=$data[0];
			$smarty->assign($data);
			$gdata=array(
					'tab'=>'?action=members&operation=saveaddr&id='.$id
					);
		}else{
			$field_array=explode(',', $field);		
			for ($i=0;$i<count($field_array);$i++){
				$smarty->assign($field_array[$i],'');
			}
			$gdata=array(
					"default_addr"=>"N",
					'tab'=>'?action=members&operation=saveaddr'
			);
		}
		include ACTION_PATH.'tools.php';
		$tools=new tools();
		$gdata+=array(
				"default_addr_options"=>array("Y"=>"是","N"=>"否"),				
				'province_options'=>$tools->area(),
				'city_options'=>'请选择市...',
				'city'=>'',
				'county_options'=>'请选择区/县...',
				'county'=>'',				
				);
		$smarty->assign($gdata);		
		$smarty->display(DEFAUTL_PATH.'my/address_info.htm');
	}
	/*************地址***************/
	
	/**
	 * 批量删除地址
	 */
	public function addrdel() {
		$user=new model('member_address');
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		$result = $user->where('id in ('.$idarr.')')->delete();
		C::msg('', $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 批量删除
	 */
	public function delete() {
		$user=new model('members');
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		$result = $user->where('uid in ('.$idarr.')')->delete();
		return $result;
	}

	/**
	 * 查找
	 */
	public function getlist() {
		$user=new model('members');
		$smarty=new Smarty();
		$field='uid,gid,username,nickname,password,regdate,regip,status,email';
		$url='';
		$arr=$user->where($this->where)->order($this->order)->page($smarty, array('uid','','',$url))->select($field);
		$data=array('tab'=>'?action=user&operation=select','list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'my/member_list.htm');
	}

	/**
	 * 添加视图
	 */
	public function view() {
		$user=new model('members');
		global $smarty;
		$e_id=C::get('id');
		$field='`uid`,`gid`,`username`,`nickname`,`email`,`password`,`regdate`,`regip`,`status`,`readname`,`sex`,`birth`,`province`,`city`,`address`,`mobile`,`tel`,`qq`';
		if (!empty($e_id)){
			$smarty->assign("tab","?action=members&operation=save&id=".$e_id);
			$data=$user->where('uid='.$e_id)->select($field);
			$smarty->assign($data[0]);
		}else{
			$smarty->assign("tab","?action=members&operation=save");
			$field_array=explode(',', $field);
			for ($i=0;$i<count($field_array);$i++){
				$smarty->assign(str_replace('`', '', $field_array[$i]),'');
			}
			$smarty->assign('sex','男');
		}
		include ACTION_PATH.'tools.php';
		$tools=new tools();
		$gdata=array(
				'sex_options'=>array('男'=>'男','女'=>'女','保密'=>'保密'),
				'province_options'=>$tools->area(),
				'city_options'=>'请选择市...',
				);
		$smarty->assign($gdata);
		$smarty->assign('gid_options',$this->group());
		$smarty->assign('password','');
		$smarty->display(DEFAUTL_PATH.'my/member_info.htm');
	}

	/**
	 * 查找会员组
	 * Enter description here ...
	 */
	public function group(){
		$group=new model('member_group');
		$glist=$group->select('gid,groupname');
		$result=array();
		foreach ($glist as $row){
			$result+=array(
			$row['gid']=>$row['groupname'],
			);
		}
		return $result;
	}

	// 会员登陆
	function login($url='') {
		if (!isset($_SESSION["code"]) || $_SESSION["code"]!=get('verifycode') || get('verifycode')===null){
			msg('验证码错误', '-1');
			exit(0);
		}
		$msg = '';
		$username=C::get('username');
		$password=sha1(C::get('password'));
		$user=new model('members');
		$yes=$user->where("username='".$username."'")->getField('count(uid)');
		if ($yes>0){
			$field='uid,username,nickname,password,status,gid';
			$arr=$user->where("username='".$username."'")->find($field);
			if ($arr[3]==$password){
				$msg=array($arr[0],$arr[1],$arr[2],$arr[5]);
				$_SESSION['auth_user']=C::_authcode($arr[0].'\t'.$arr[1].'\t'.$arr[5]);
				$msg=array($arr[0],$arr[1],$arr[5]);
			}else{
				$msg=array('-2','','');//密码错
			}
		}
		else{
			$msg=array('-1','','');//账号不存在
		}
		return $msg;
	}

	// 用户退出
	function logout($url='') {
		unset($_SESSION['auth_user']);
		if (empty($url)){
			C::msg('', 'admin.php?action=members&operation=login_index','parent');
		}else{
			C::msg('', $url);
		}
	}

	function login_index(){
		$smarty=new Smarty();
		if (isset($_SESSION['auth_user'])){
			list($uid, $username,$gid) = explode('\t', C::_authcode($_SESSION['auth_user'],'DECODE'));
			$data=array(
					'display'=>"style='display:none;'",
					'username'=>$username
					);
		}else{
			$data=array(
					'display'=>'',
					'username'=>''
			);
		}
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'login.htm');
	}
}

?>