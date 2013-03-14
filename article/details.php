<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
$id=C::get('id');
$art=new model('article');
$field='aid,title,fid,uid,photo,readperm,source,status,highlight,property,seotitle,keywords,description,links,label,intro,discuss,add_time,hits';
$data=$art->where('aid='.$id)->select($field);
$des=new model('article_descrip');
$content=$des->where('aid='.$id)->getField('content');
$a_class=C::getclass('article_classify');
$_odata=array(
		'content'=>C::noHtmlRepace($content),
		'seotitle'=>'',
		'keywords'=>'',
		'description'=>'',
		'a_class'=>$a_class);
$art->where('aid='.$id)->setInc('hits', 1);
$smarty->assign($data[0]);
$smarty->assign($_odata);
$smarty->display(DEFAUTL_PATH."article/details.htm");