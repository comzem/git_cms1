<?php
header("Content-Type:text/html;charset=utf-8");
error_reporting(15);
define('IN_CMS', true);

//网站开始时间
define('SYS_START_TIME', microtime());
define('ROOT_PATH',str_replace("inc/constant.php", "", str_replace("\\", "/", __FILE__)));
define('LIB_PATH', ROOT_PATH.'source/');

//控制器
define('ACTION_PATH', ROOT_PATH.'source/action/');

//操作操作类目录
define('CLASS_PATH', ROOT_PATH.'source/classes/');
define('FUNC_PATH', ROOT_PATH.'source/func/');

//常用函数
define('COMMON', ROOT_PATH.'inc/');
define('THEMES_PATH', ROOT_PATH);

define('UPLOAD_PATH', 'upload/');

require dirname(dirname(__FILE__)).'/data/config.php';
include COMMON.'common.php';
include COMMON.'common.fun.php';
include CLASS_PATH.'model.class.php';
include ROOT_PATH.'Smarty/Smarty.class.php';
include COMMON.'SubPages.class.php';

//获取配置信息
$_CFG=load_config();
if ($_CFG['system'][0]=='3'){
	die($_CFG['system'][4]);
}
/* 创建 Smarty 对象。*/
$smarty=new Smarty();
$smarty->debugging=false;
$smarty->caching=false;

//每次输出模板的时候检查当前模板是否有过改变,如果有那么重新编译(判断时间戳)
$smarty->compile_check=$_CFG['system'][5];
$smarty->template_dir=ROOT_PATH."template";
$smarty->compile_dir=ROOT_PATH."templates_c";
$smarty->config_dir=ROOT_PATH."configs";
$smarty->cache_dir=ROOT_PATH."cache";
$smarty->security_settings = 'truncate_cn';