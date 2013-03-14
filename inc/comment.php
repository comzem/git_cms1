<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
require COMMON.'ajaxpages.php';
$comment=new model('goods_comments');

$page_size=10;//每页显示的条数
$fid=get('fid');
$pid=get('pid');
$nums=$comment->where("closed=1 and fid=$fid and pid=$pid")->getField('count(cid)');//总条目数
$sub_pages=10;//每次显示的页数
$pageCurrent=1;
$offset=0;
if (isset($_GET["p"]))
{
	$pageCurrent=$_GET["p"];
	$offset=$page_size*($pageCurrent-1);
}

$arr=$comment->limit("$offset".','."$page_size")->select('username,add_time,content');

for($i=0;$i<count($arr);$i++){
	//echo "<li><img class=\"imgclick\" src=\"upload/".$arr[$i]['attachment']."\" title=\"点击选择".$arr[$i]['attachment']."\" /></li>";
	echo '<ul class="mat5"><li class="fl">会员：'.$arr[$i]['username'].'</li>
	      <li class="fr">咨询日期：'.date("Y-m-d H:i:s",$arr[$i]['add_time']).'</li>
		 </ul>
		 <div class="padb10 mal10 lh18">
		 <div class="mat10 font14">'.$arr[$i]['content'].'</div></div>';
}

$page=new ajaxpages($page_size, $nums, $pageCurrent, 10);
echo '<div class="ajaxpage">'.$page->subPageCss2().'</div>';