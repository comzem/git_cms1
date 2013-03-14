<?php
require dirname(dirname(dirname(__FILE__))).'/inc/init_cms.php';
$link=mysql_connect('127.0.0.1','root','123456');
mysql_query("SET names utf8", $link);
mysql_select_db('cms_20130108', $link);

$spbh=C::get('spbh');//商品编号
$cz=C::get('cz');//材质

$ys=C::get('ys');//颜色
$ys='<option'.$ys.'option>';
$ys=str_replace("><", ">\n<", $ys);
$cm=C::get('cm');//尺码
$cm='<option'.$cm.'option>';
$cm=str_replace("><", ">\n<", $cm);
preg_match_all ("|<option.*value=\'(.*)\'>.*</option>|", $ys, $out_ys, PREG_PATTERN_ORDER);
preg_match_all ("|<option.*value=\'(.*)\'>.*</option>|", $cm, $out_cm, PREG_PATTERN_ORDER);

$jg=C::get('jg');//价格
$tp=GrabImage(C::get('tp'));//GrabImage(C::get('tp'))
$title=C::get('title');
$content=C::get('content');
$blb=C::get('blb');//大类
$slb=C::get('slb');//小类
//iconv("utf-8","utf-8", $blb);
//分类
//有多少个小分类

$f_str="select count(fid) from cms_goods_classify where title='$slb'";
//查找小类fid
$f_str1="select fid from cms_goods_classify where title='$slb'";

$f_query=mysql_query($f_str,$link);

$total_id=mysql_result($f_query, 0);
echo ($slb);
return;

$fid=mysql_result(mysql_query($f_str1,$link),0);


if ($total_id>1){
	//大类id
	$f_str2="select fid from cms_goods_classify where title='$blb'";
	$_bid=mysql_result(mysql_query($f_str2,$link),0);
	$f_str3="select fid from cms_goods_classify where title='$slb' and fid=$_bid";
	$fid=mysql_result(mysql_query($f_str3,$link),0);
}

//产品信息
$fid=1;
$time=time();
$str="insert into cms_goods(fid,title,price1,photo,bianma,material,add_time,ip)";
$str.=" values($fid,'".C::LeftStr($title,50)."',$jg,'".str_replace('../../upload/', '', $tp)."','".C::LeftStr($spbh,20)."','".C::LeftStr($cz,20)."',$time,'".C::ip()."')";

mysql_query($str,$link);
$pid=insert_id($link);

//添加描述
$des_sql="insert into cms_goods_descrip(pid,content) values($pid,'".($content)."')";
mysql_query($des_sql,$link);
//echo $des_sql;
//添加图片
$attach=new model('goods_attachment');
$img_data=array('pid'=>$pid,'attachment'=>str_replace('../../upload/', '', $tp));
$attach->data($img_data)->add();
//echo $des_sql;
 //属性
 $property=new model('goods_property');
 //颜色

 $ys_data=array();
 for($i=0;$i<count($out_ys[1]);$i++){
 	$ysql="insert into cms_goods_property(pid,skey,svalue) values($pid,'yanse','".$out_ys[1][$i]."')";
 	mysql_query($ysql,$link);
 	//echo $ysql;
 }
 //尺码
 $cm_data=array();
 for($i=0;$i<count($out_cm[1]);$i++){
	$ysql="insert into cms_goods_property(pid,skey,svalue) values($pid,'chima','".$out_cm[1][$i]."')";
 	mysql_query($ysql,$link);
 }
//$property->data($ys_data)->addAll();
//$property->data($cm_data)->addAll();
//var_dump($ys_data);

//获取远程图片并把它保存到本地
function GrabImage($url,$filename="") {
	if($url==""):return false;endif;
	if($filename=="") {
		$ext=strrchr($url,".");
		if($ext!=".gif" && $ext!=".jpg"):return false;endif;
		$filename=date("dMYHis").$ext;
	}
	ob_start();
	readfile($url);
	$img = ob_get_contents();
	ob_end_clean();
	$size = strlen($img);
	$filename='../../upload/'.date("ym").'/'.$filename;
	$fp2=@fopen($filename, "a");
	fwrite($fp2,$img);
	fclose($fp2);
	return $filename;
}
function insert_id($link){
	return ($id = mysql_insert_id($link)) >= 0 ? $id : mysql_result(mysql_query("SELECT last_insert_id()",$link), 1);
}

if ($pid>0){
	echo '1';
	return;
}else{
	echo '0';
	return ;
}

