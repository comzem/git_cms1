<?php
define('C_DBHOST', '127.0.0.1');
			
define('C_DBUSER', 'root');
			
define('C_DBPW', '123456');
			
define('C_DBNAME', 'ddddddddddddddddddddd');
			
define('C_DBCHARSET', 'utf8');
			
define('WEB_KEY', '2c60c24e7087e18e45055a33f9a5be91');
define('PRE', 'asda_');

$webarr=array('localhost');

if (!in_array($_SERVER['HTTP_HOST'], $webarr)){
	exit(0);
}