<?php
header('Content-type:image/PNG;charset=utf-8;');
include 'GD.class.php';
$gd=new GD();
if (isset($_GET["t"]) && $_GET["t"]=="simple")
{
	$gd->ver_code2();
}
elseif(isset($_GET["t"]) && $_GET["t"]=="general")
{
	$gd->smi_code();
}
elseif(isset($_GET["t"]) && $_GET["t"]=="tel"){
	$gd->createimg($_GET['str']);
}
//图片水印，缩略图
?>