<?php
header("Content-Type:text/html;charset=utf-8");
//$f=file_get_contents('install/descrip1.txt');
//echo $f;
$a=readsql('install/data.txt');
var_dump($a);
function readsql($file){
	$fp=fopen($file, 'r');
	$sql=array();
	$sql1=array();
	while (!feof($fp)){
		$sql[]=fgets($fp);
	}
	$str='';
	$str1='';
	for($i=0;$i<count($sql);$i++){
		$str1=trim($sql[$i]);
		if (!empty($str1)){
			$str.=$sql[$i];
		}else{
			$sql1[]=$str;
			$str='';
		}
	}
	return $sql1;
}