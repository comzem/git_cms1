<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
$g=$_CFG['display'];
$goods=new model('goods');
$field='pid,title,price1,photo,type,bianma,dazhe';
$where='status=1';
$order="$g[0]"." "."$g[1]";
$id=C::get('id');
$url='?p=';
if (!empty($id)){
	$url='?id='.$id.'&p=';
	$id_list=explode(',', $id);
	if ($id_list[1]>0){
		$where.=' and fid='.$id_list[1];
	}else{
		$where.=" and (fid in (select fid from cms_goods_classify where upid=$id_list[0]) or fid=".$id_list[1].")";
	}
}
$kw=C::get('kw');
if (!empty($kw)){
	$url='?kw='.$kw.'&p=';
	$where.=" and title like '%".$kw."%'";
}

$data=$goods->where($where)->order($order)->page($smarty, array('pid',$g[3],'',$url))->select($field);
$rx=$goods->limit(8)->select($field);
$_odata=array(
		'list'=>$data,
		'seotitle'=>'产品列表页',
		'jgdisplay'=>$_CFG['display'][4],
		'rx'=>$rx);
$smarty->assign($_odata);
$smarty->display(DEFAUTL_PATH.'shop/search_product.htm');