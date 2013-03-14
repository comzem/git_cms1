<?php 
define('ROOT_PATH',str_replace("install/index.php", "", str_replace("\\", "/", __FILE__)));
define('TEMP_PATH', ROOT_PATH.'install/templates/');
include ROOT_PATH.'inc/common.fun.php';
include ROOT_PATH.'Smarty/Smarty.class.php';
if (file_exists('../data/config.php')){
	echo "<div style='margin-top: 8px; line-height: 180%; color: #FF0000;background:#FBBA93; text-align:center;'><h2>已安装完成，不需要重新安装</h2></div>";
	exit(0);
}
inst_start();
$act=get('step');

$smarty=new Smarty();
$smarty->debugging=false;
$smarty->caching=false;
//每次输出模板的时候检查当前模板是否有过改变,如果有那么重新编译(判断时间戳)
$smarty->compile_check=true;
$smarty->template_dir=TEMP_PATH."template";
$smarty->compile_dir=TEMP_PATH."templates_c";
$smarty->config_dir=TEMP_PATH."configs";
$smarty->cache_dir=TEMP_PATH."cache";
$smarty->left_delimiter="{#";
$smarty->right_delimiter="#}";
$show='style="display:none;"';
if (empty($act)){
	$act='1';
}
switch ($act){
	case '1':
		break;
	case '2':		
		$system_info=array();
		$system_info['os']=PHP_OS;
		$system_info['web_server']=$_SERVER['SERVER_SOFTWARE'];
		$system_info['php_ver'] = PHP_VERSION;
		$system_info['max_filesize'] = ini_get('upload_max_filesize');
		if (PHP_VERSION<5.0) exit("安装失败，请使用PHP5.0及以上版本");
		$smarty->assign('system_info',$system_info);
		$smarty->assign('dir_check',check_dir());
		$smarty->assign('next',check_dir('1'));
		break;
	case '4':
		//数据库信息
		$dbhost=get('dbhost');
		$dbuser=get('dbuser');
		$dbpass=get('dbpass');
		$dbname=get('dbname');
		$pre=get('pre');
		//管理员信息
		$admin_name=get('admin_name');
		$admin_pwd=get('admin_pwd');
		$admin_pwd1=get('admin_pwd1');
		$admin_email=get('admin_email');
		if ($admin_pwd!=$admin_pwd1 || empty($admin_pwd)){
			msg('两次输入密码不一致或密码为空，请重新输入！', '-1');
			exit(0);
		}
		//配置信息
		$doname=get('doname');
		$key=get('key');		
		if (empty($doname) || empty($key)){
			msg('请输入域名或key', '-1');
			exit(0);
		}
		$tablename='';
		$createtable='';
		if (!$links=mysql_connect($dbhost,$dbuser,$dbpass)){
			die("连接错误");
		}else{
			//创建数据库
			@mysql_query('CREATE DATABASE IF NOT EXISTS `'.$dbname.'` DEFAULT CHARACTER SET utf8',$links);
			mysql_select_db($dbname, $links);
			mysql_query("set names utf8",$links);
			$db_list=readsql('db.txt');
			for ($i=0;$i<count($db_list);$i++){
				if (!empty($db_list[$i]) && strpos($db_list[$i], "ENGINE=MyISAM")==false){
					$tablename=trim($pre.$db_list[$i]);					
				}
				if (strpos($db_list[$i], "ENGINE=MyISAM")){
					$createtable='CREATE TABLE `'.$tablename.'`'.$db_list[$i];
				}
				//echo $createtable;
				//1、删除已有表
				mysql_query('DROP TABLE IF EXISTS `'.$tablename.'`');
				//2、创建表
				mysql_query($createtable);
				$msg1='建立数据表'.$tablename.'...成功';
				$smarty->assign('msg',$msg1);
			}
			$data_list=readsql('data.txt');
			$initial_data='';
			$initial_sql='';
			
			//初始化数据
			for($j=0;$j<count($data_list);$j++){
				if (!empty($data_list[$j])){
					$initial_data=explode('__', $data_list[$j]);
					$initial_sql='insert into `'.$pre.$initial_data[0].'`'.$initial_data[1];
					mysql_query($initial_sql);
					$msg1='初始化数据'.$pre.$initial_data[0].'...成功';
					$smarty->assign('msg',$msg1);
				}
			}
			$admin_pwd=sha1($admin_pwd);
			$admin_sql="insert into ".$pre."members(gid,username,email,password) values(1,'$admin_name','$admin_email','$admin_pwd')";
			mysql_query($admin_sql,$links);
			$key=md5($key);
			$doname=str_replace(',', "','", $doname);
			$xx="<?php\ndefine('C_DBHOST', '$dbhost');
			
define('C_DBUSER', '$dbuser');
			
define('C_DBPW', '$dbpass');
			
define('C_DBNAME', '$dbname');
			
define('C_DBCHARSET', 'utf8');
			
define('WEB_KEY', '$key');
define('PRE', '$pre');

\$webarr=array('".$doname."');

if (!in_array(\$_SERVER['HTTP_HOST'], \$webarr)){
	exit(0);
}";
			file_put_contents('./../data/config.php', $xx);
			file_put_contents('./../data/install.lock','ok');
			$smarty->assign('msg','您已安装成功!');
			$show='';
		}
		break;
}
$data=array(
		'act'=>$act,
		'path'=>TEMP_PATH,
		'show'=>$show
);
$smarty->assign($data);
$smarty->display(TEMP_PATH.'step'.$act.'.htm');

function readsql($file){
	$fp=fopen($file, 'r');
	$sql=array();
	$sql1=array();
	while (!feof($fp)){
		$sql[]=fgets($fp);
	}
	$str='';
	$str1='';
	for($i=0;$i<count($sql);$i++){
		$str1=trim($sql[$i]);
		if (!empty($str1)){
			$str.=$sql[$i];
		}else{
			$sql1[]=$str;
			$str='';
		}
	}
	return $sql1;
}

function inst_start(){
	$str='';
	if (!is_readable(TEMP_PATH)){
		$str.='templates不可读<br>';
	}
	if (!is_writeable(TEMP_PATH)){
		$str.='templates不可写<br>';
	}
	if (!is_readable(TEMP_PATH.'templates_c')){
		$str.='templates_c不可读<br>';
	}
	if (!is_writeable(TEMP_PATH.'templates_c')){
		$str.='templates不可写<br>';
	}
	!empty($str)?die($str.'请检查权限是否设置正确'):'';
}

function check_dir($s=''){
	$dirs = array(
			'data',
			'cache',
			'template',
			'templates_c',
			'backup/databack',
			'upload'
	);
	$path=ROOT_PATH.'install/';
	$result=array();
	$resultbool=1;
	for($i=0;$i<count($dirs);$i++){
		$result[$i]['dir']=$dirs[$i];
		if (!file_exists(ROOT_PATH.$dirs[$i])){
			$result[$i]['read']='目录不存在';
			$result[$i]['write']='目录不存在';
			$resultbool=0;
		}else{
			if (is_readable(ROOT_PATH.$dirs[$i]))
			{
				$result[$i]['read'] = '<span style="color:green;">√可读</span>';
			}else{
				$result[$i]['read'] = '<span sylt="color:red;">×不可读</span>';
				$resultbool=0;
			}
			if(is_writable(ROOT_PATH.$dirs[$i])){
				$result[$i]['write'] = '<span style="color:green;">√可写</span>';
			}else{
				$result[$i]['write'] = '<span style="color:red;">×不可写</span>';
				$resultbool=0;
			}
		}
	}
	if (!empty($s))
		return $resultbool;
	else
		return $result;
}