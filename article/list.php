<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
$art=new model('article');
$field='aid,title,fid,photo,property,links,label,intro,discuss,add_time,hits';
$url='?p=';
$where='';
$fid=C::get('fid');
if (!empty($fid)){
	$where='fid='.$fid;
	$url='fid='.$fid.'?p=';
}
$data=$art->where($where)->page($smarty, array('','','',$url))->select($field);
$a_class=C::getclass('article_classify');
$_odata=array(
		'seotitle'=>'',
		'keywords'=>'',
		'description'=>'',
		'a_class'=>$a_class
);
$smarty->assign('list',$data);
$smarty->assign($_odata);
$smarty->display(DEFAUTL_PATH."article/list.htm");