<?php
include dirname(__FILE__).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
require FUNC_PATH.'index.fun.php';

//资讯
$art=new model('article');
$a_data=$art->where('fid=39')->limit(8)->select('aid,title');
$t_data=$art->where('fid=40')->limit(5)->select('aid,title');
$links=new model('links');
$l_data=$links->order('sort asc,id asc')->limit(20)->select('sitename,url');
$tu=new model('tu');
$data=array(
		'tu'=>$tu->limit(6)->select('url,title,attach'),
		'list'=>tj(),
		'news'=>$a_data,
		'tz'=>$t_data,
		'plist'=>getindex(),
		'jgdisplay'=>$_CFG['display'][4],
		'links'=>$l_data);
$smarty->assign($data);
$smarty->display(DEFAUTL_PATH.'index.htm');