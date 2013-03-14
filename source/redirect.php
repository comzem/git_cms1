<?php 
if (isset($_GET['msg']) && isset($_GET['url'])){
	$msg=$_GET['msg'];
	$url=urldecode($_GET['url']);
	//echo $url;
	//exit(0);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
body {
	width: 95%;
	margin: 0px auto;
	padding: 0;
}
#mpt {
	margin: 0px auto;
	border: 3px solid #deeffa;
	border-left-width: 0px;
	border-right-width: 0px;
	background-color: #f2f9fd;
}
#info {
	line-height: 45px;
	font-size: 15px;
	padding-left: 200px;
}
.tabTop {
	width: 95%;
	text-indent: 15px;
	height: 32px;
	line-height: 32px;
	margin-top: 30px;
	font-size: 14px;
	font-weight: bold;
	text-indent: 15px;
}
</style>
</head>

<body>
<script language="javascript">setTimeout("location.href='<?php echo $url; ?>'",3000);</script>
<div class="tabTop">提示信息</div>
<div id="mpt">
  <div id="info"><?php echo $msg; ?>3秒后跳转到>> <br />
    <a href="<?php echo $url; ?>">如果浏览器没反应，请点击这里...</a></div>
</div>
</body>
</html>