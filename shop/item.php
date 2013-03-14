<?php
include dirname(dirname(__FILE__)).'/inc/init_cms.php';
defined('IN_CMS') or exit('No permission resources.');
$goods=new model('goods');
$id=C::get('id');
$field='pid,fid,title,status,price1,amount,point,photo,seotitle,keywords,description,yuanfei,pingyou,kuaidi,ems,buynum,pingjia,city1,city2,type,bianma,dazhe,hits,add_time';
$data=$goods->where('pid='.$id)->select($field);
$data=$data[0];
$des=new model('goods_descrip');
$content=$des->where('pid='.$id)->getField('content');

$seotitle=empty($data['seotitle'])?$data['title']:$data['seotitle'];
$keywords=empty($data['keywords'])?$seo[19]:$data['keywords'];
$description=empty($data['keywords'])?$seo[20]:$data['description'];

$cls=new model('goods_classify');
$classify=$cls->where('fid='.$data['fid'])->getField('title');

$ys_arr=array();
$cm_arr=array();

/*******产品属性********/
$dis='style="display:none"';
$script="";//生成脚本
$script_cont="";
$proinput="";
$pr=new model('goods_property');
$pr_data=$pr->where('pid='.$id)->select('skey,svalue');
$property=array();

if (!empty($pr_data)){
	$dis='';
	$i=0;
	foreach ($pr_data as $row){
		if (!empty($row['svalue'])){
			$v_arr=array();
			$sv=explode(',', $row['svalue']);
			foreach ($sv as $r){
				$v_arr[]=array('val'=>$r);
			}
			$property[]=array(
						'skey'=>$row['skey'],
						'form'=>'property_'.$i,
						'formcont'=>'<input name="property_'.$i.'" id="property_'.$i.'" type="hidden" value="" />',
						'sub'=>$v_arr
					);
			$proinput.=",property_$i";
			
			$script_cont.="if ($(\"#property_$i\").val()==\"\"){alert(\"请选择".$row['skey']."\");return false;}";
			$i++;
		}
	}
	$proinput=!empty($proinput)?substr($proinput, 1):$proinput;
	$script="<script>\n\$(function(){\n\$(\"#buy_product\").click(function(){\n".$script_cont."form2.submit();});\n})</script>";
}
/*******产品属性********/

$img=new model('goods_attachment');
$img_data=$img->where('pid='.$id)->select('attachment');

/*******评论********/
$pl=new model('goods_comments');
$pl_list=$pl->where('fid=1 and closed=1 and pid='.$id)->limit(15)->select('username,add_time,content');
$pj_list=$pl->where('fid=2 and closed=1 and pid='.$id)->limit(15)->select('username,add_time,content');
$rx=$goods->limit(8)->select($field);

$_odata=array(
		'classify'=>'> '.$classify,
		'seotitle'=>$seotitle,
		'keywords'=>$keywords,
		'description'=>$description,
		'content'=>$content,
		'dis'=>$dis,
		'p'=>$property,
		'script'=>$script,
		'proinput'=>$proinput,
		'img'=>$img_data,
		'pl'=>$pl_list,
		'pj'=>$pj_list,
		'jgdisplay'=>$_CFG['display'][4],
		'pl_total'=>$pl->where('fid=1 and closed=1 and pid='.$id)->getField('count(cid)'),
		'pj_total'=>$pl->where('fid=2 and closed=1 and pid='.$id)->getField('count(cid)'),
		'fuwu'=>$sing->where('id='.$_CFG['display'][6])->getField('content'),
		'rx'=>$rx);
$goods->where('pid='.$id)->setInc('hits', 13);
$smarty->assign($data);
$smarty->assign($_odata);
$smarty->display(DEFAUTL_PATH.'shop/item.htm');