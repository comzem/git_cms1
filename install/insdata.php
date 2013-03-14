<?php
//,'descrip38.php','descrip42.php','descrip43.php'
$data=array('goods1.php','goods2.php','goods3.php','goods4.php','goods5.php','property1.php','property2.php','attachment.php',
		'descrip1.php','descrip2.php','descrip3.php','descrip4.php','descrip5.php','descrip6.php','descrip7.php','descrip8.php'
		,'descrip9.php','descrip10.php','descrip11.php','descrip12.php','descrip13.php','descrip14.php','descrip15.php','descrip16.php'
		,'descrip17.php','descrip18.php','descrip19.php','descrip20.php','descrip21.php','descrip22.php','descrip23.php','descrip24.php'
		,'descrip25.php','descrip26.php','descrip27.php','descrip28.php','descrip29.php','descrip30.php','descrip31.php','descrip32.php'
		,'descrip33.php','descrip34.php','descrip35.php','descrip36.php','descrip37.php','descrip39.php','descrip40.php'
		,'descrip41.php','descrip44.php','descrip45.php'
		);
$server=$_POST['dbserver'];
$dbname=$_POST['dbname'];
$dbuser=$_POST['dbuser'];
$dbpw=$_POST['dbpw'];
if (!$links=mysql_connect($server,$dbuser,$dbpw)){
	die("连接错误");
}else{	
	mysql_select_db($dbname, $links);
	mysql_query("set names utf8");
	
	//$content=file('data/'.$data[4]);
	
	//echo $content[0];
	for($i=0;$i<count($data);$i++){
		require 'data/'.$data[$i];
		mysql_query($str,$links);
		//$content=file('data/'.$data[$i]);
		//mysql_query($content[0],$links);
		echo str_replace('.php', '', $data[$i]).'导入成功<br>';
	}
	echo '<br><br>数据导入完成...';
}
$str="";