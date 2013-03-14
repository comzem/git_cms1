<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
require COMMON.'ajaxpages.php';
$attach=new model('goods_attachment');

$page_size=10;//每页显示的条数
$nums=$attach->getField('count(pid)');//总条目数
$sub_pages=10;//每次显示的页数
$pageCurrent=1;
$offset=0;
if (isset($_GET["p"]))
{
	$pageCurrent=$_GET["p"];
	$offset=$page_size*($pageCurrent-1);
}

$arr=$attach->limit("$offset".','."$page_size")->select('pid,attachment');
echo '<ul class="attlist">';
for($i=0;$i<count($arr);$i++){
	echo "<li><img class=\"imgclick\" src=\"upload/".$arr[$i]['attachment']."\" title=\"点击选择".$arr[$i]['attachment']."\" /></li>";
}
echo '</ul>';
$page=new ajaxpages($page_size, $nums, $pageCurrent, 10);
echo '<div class="ajaxpage">'.$page->subPageCss2().'</div>';