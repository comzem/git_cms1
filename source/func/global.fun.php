<?php
//商品分类
$class=C::getclass('goods_classify');
$nav=new model('nav');
$topnav=$nav->where('upid=1')->order('sort asc,fid asc')->select('title,urls,target');

//站点全局信息
$footmsg=$_CFG['foot'][0];
$site=$_CFG['website'];
//seo设置
$seo=$_CFG['seo'];
//底部帮助
$sing=new model('single');
$h_1=$sing->where('fid=1')->select('id,title');
$h_2=$sing->where('fid=2')->select('id,title');
$h_3=$sing->where('fid=3')->select('id,title');
$h_4=$sing->where('fid=4')->select('id,title');
$online=explode(',', $site[5]);
$online_string='';$online_string1='';
for($i=0;$i<count($online);$i++){
	$online_string.="<tr><td align='center' style='border-left:solid 1px #dde6ec;border-right:solid 1px #dde6ec;height:26px;background:#fff;'><a href='tencent://message/?uin=$online[$i]&Site=&Menu=yes'><img  border='0' align='absmiddle' src='http://wpa.qq.com/pa?p=4:$online[$i]:4' title='点击QQ与我们交流'/>服务咨询</a>	</td></tr>";
	$online_string1.='<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$online[$i].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$online[$i].':41" alt="点击这里给我发消息" title="点击这里给我发消息"></a>  ';
}
$endnav=$nav->where('upid=3')->order('sort asc,fid asc')->select('title,urls,target');

//全局内容配置
$global_data=array(
		'domain'=>$site[1],
		'webname'=>$site[0],
		'tpl'=>'/'.$tmp_path,
		'seotitle'=>$seo[0],
		'keywords'=>$seo[1],
		'description'=>$seo[2],
		'uid'=>$uid,
		'username'=>$username,
		'path'=>DEFAUTL_PATH,
		'nav'=>$class,
		'topnav'=>$topnav,
		'help_1'=>$h_1,
		'help_2'=>$h_2,
		'help_3'=>$h_3,
		'help_4'=>$h_4,
		'tel'=>$site[3],
		'endnav'=>$endnav,
		'online'=>$online_string,
		'online1'=>$online_string1,
		'logo'=>$site[1].'/'.$_CFG['website'][8],
		'footmsg'=>$footmsg);
$smarty->assign($global_data);