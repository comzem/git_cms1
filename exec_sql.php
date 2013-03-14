<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>执行SQL</title>
<link href="css/css.css" rel="stylesheet"type="text/css" />
<?php 
include 'source/classes/DcMysql.class.php';
include 'data/config.php';
$db=new DcMysql();
$db->connect(C_DBHOST, C_DBUSER, C_DBPW, C_DBNAME);
$sql="";
if (isset($_POST['query'])){
	$sql=$_POST['sqltxt'];
	//echo $sql;
	$arr=$db->getAll($sql);
	var_dump($arr);
}	
if (isset($_POST['exec'])){
	$sql=$_POST['sqltxt'];
	$db->execute($sql);
}
?>
</head>

<body>
<div class="tbbody">
  <div class="nav_bg1">执行SQL</div>
  <form action="" method="post" name="form1" id="form1">
    <textarea name="sqltxt" id="sqltxt" cols="50" rows="7"></textarea>
    <input type="submit" name="query" id="button2" value="查询" />
    <input type="submit" name="exec" id="button" value="执行" onclick="if (confirm('确定执行吗')) {return true} return false;" />
  </form>
  <div>
  	
  </div>
</div>
</body>
</html>