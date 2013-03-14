<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
require FUNC_PATH.'forumcp.php';
$forumcp=new forumcp($smarty);
$mod_list=array(
		'index'=>array('forum'),
		'forumdisplay'=>array(),
		'viewthread'=>array(),
		);


