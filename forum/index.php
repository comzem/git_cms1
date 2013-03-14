<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
$smarty->display(DEFAUTL_PATH.'forum/index.htm');