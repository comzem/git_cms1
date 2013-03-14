<?php
include '../init.php';
if (isset($_GET['url']) && !empty($_GET['url'])){
	$url=$_GET['url'];
	if(!empty($_COOKIE['user_auth'])){		
		header("Location:".$url);
	}else{
		header("Location:login.php?url=".$url);
	}
}
