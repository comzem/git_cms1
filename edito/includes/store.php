<?php
header("Content-Type:text/html;charset=utf-8");
include '../init.php';
//服务信息
if (isset($_GET['level_id']) && !empty($_GET['level_id'])){
	include MODEL_PATH.'Company_otherModel.php';
	$other=new Company_otherModel();
	$level_id=Common::isint($_GET['level_id']);
	$where="level_id=".$level_id;
	$order="sort asc,id asc";
	$limit=0;
	$arr=$other->select($where,$order,$limit);
	$listarr=array();
	$result="";
	if (is_array($arr))
	{
		$result="<ul>";
		foreach ($arr as $row)
		{
			$listarr[]=array("id"=>$row['id'],"title"=>$row['title'],"level_id"=>$row['level_id'],"sort"=>$row['sort']);
			$result.="<li><input type=\"checkbox\" class=\"checkfuwu\" name=\"fuwuchk\" value=\"".$row['id']."|".$row['title']."\" />".$row['title']."</li>";
		}
		$result.="</ul>";
	}
	echo $result;
	exit(0);
}
//产品分类
if (isset($_GET['hunjia']) && !empty($_GET['hunjia'])){
	include MODEL_PATH.'Tmall_productsModel.php';
	$products=new Tmall_productsModel();
	$level_id=Common::isint($_GET['hunjia']);
	$where="level_id=".$level_id;
	$order="sort asc,id asc";
	$limit=0;
	$arr=$products->select($where,$order,$limit);
	$listarr=array();
	$result="";
	if (is_array($arr))
	{
		foreach ($arr as $row)
		{
			$result.="<input type=\"checkbox\" name=\"txt_hjclass[]\" value=\"".$row['id']."\" />".$row['prods_title']."";
		}
	}
	echo $result;
	exit(0);
}

//菜系
if (isset($_GET['caixi']) && !empty($_GET['caixi'])){
	include MODEL_PATH.'Tmall_productsModel.php';
	$products=new Tmall_productsModel();
	$level_id=Common::isint($_GET['caixi']);
	$where="level_id=".$level_id;
	$order="sort asc,id asc";
	$limit=0;
	$arr=$products->select($where,$order,$limit);
	$listarr=array();
	$result="";
	if (is_array($arr))
	{
		$result="<ul>";
		foreach ($arr as $row)
		{
			$result.="<li><input type=\"checkbox\" class=\"checkfuwu\" name=\"fuwuchk\" value=\"".$row['id']."|".$row['prods_title']."\" />".$row['prods_title']."</li>";
		}
		$result.="</ul>";
	}
	echo $result;
	exit(0);
}