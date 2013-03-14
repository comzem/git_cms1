<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
$id=C::get('id');
$field='id,title,fid,content,sort,status,add_time,seotitle,keywords,description';
$data=$sing->where('id='.$id)->select($field);
$a_class=C::getclass('article_classify');
$_odata=array(
		'content'=>C::noHtmlRepace($data[0]['content']),
		'seotitle'=>'',
		'keywords'=>'',
		'description'=>'',
		'a_class'=>$a_class
);
$smarty->assign($data[0]);
$smarty->assign($_odata);
$smarty->display(DEFAUTL_PATH."article/page.htm");