<?php
/**
 * $_REQUEST key,value
 * Enter description here ...
 * @param unknown_type $k
 * @param unknown_type $var
 */
function get($k,$var='R'){
	switch ($var){
		case 'G': $var=&$_GET; break;
		case 'P': $var=&$_POST; break;
		case 'C': $var=&$_COOKIE; break;
		case 'R': $var=&$_REQUEST; break;
	}
	return isset($var[$k])?(is_array($var[$k])?$var[$k]:trim(addslashes($var[$k]))):NULL;
}

/**
 * 页面跳转
 * Enter description here ...
 * @param unknown_type $msg
 * @param unknown_type $url
 * @param unknown_type $blank
 */
function msg($msg,$url,$blank=''){
	$alert='';
	if (isset($msg) && !empty($msg)){
		$alert="alert('".$msg."');";
	}
	$href='';
	if (isset($url) && !empty($url)){
		if ($url=='-1'){
			$href="history.go(-1);";
		}else{
			$href="location.href='".$url."';";
			if (!empty($blank)){
				$href=$blank.".location.href='".$url."';";
			}
		}
	}
	echo "<script>$alert"."$href</script>";
}

/**
 * 把关联数组的key分割成一维数组
 * @param unknown_type $data
 */
function keyArray($data){
	$arr=array();
	if (is_array($data)){
		foreach ($data as $key=>$value){
			if ($value!=null)
				$arr[]=$key;
		}
	}
	return $arr;
}

/**
 * 把关联数组的value分割成一维数组
 * @param unknown_type $data
 * @return multitype:unknown
 */
function valueArray($data){
	$arr=array();
	if (is_array($data)){
		foreach ($data as $key=>$value){
			if ($value!=null){
				if (is_string($value))
					$arr[]="'".$value."'";
				else
					$arr[]=$value;
			}
		}
	}
	return $arr;
}

/**
 * 返回更新字段的字符串
 * @param unknown_type $data
 */
function saveString($data){
	$arr_1=self::keyArray($data);
	$arr_2=self::valueArray($data);
	$sql='';
	for($i=0;$i<count($arr_1);$i++){
		if ($arr_2[$i]!=null)
			$sql.=','.$arr_1[$i].'='.$arr_2[$i];
	}
	if (isset($sql) && !empty($sql)){
		$sql=substr($sql, 1);
	}
	return $sql;
}


/**
 *
 * @param unknown_type $data
 * @return string
 */
function addAllValue($data){
	$sql='';
	for($i=0;$i<count($data);$i++){
		$sql.=',(';
		$sql.=implode(',', self::valueArray($data[$i]));
		$sql.=')';
	}
	return substr($sql, 1);
}

/**
 * 拆分checkbox
 * @param unknown_type $val
 * @return string
 */
function getCheckbox($val){
	$list=isset($val)?$val:"";
	$chk='';
	if (!empty($list))
	{
		$total=count($list);
		for ($i=0;$i<$total;$i++){
			if (!empty($list[$i])){
				$chk.=','.$list[$i];
			}
		}
	}
	if (!empty($chk))
		$chk=substr($chk, 1);
	return $chk;
}


/**
 * 载入配置信息
 */
function load_config(){
	$set=new model('setting');
	$res=$set->select('skey,svalue');
	$arr = array();
	if (is_array($res)){
		for($i=0;$i<count($res);$i++){
			//关联数组skey=>svalue
			$arr[$res[$i]['skey']]=explode("	", $res[$i]['svalue']);
		}
	}
	return $arr;
}

/**
 * 程序执行时间
 *
 * @return	int	单位ms
 */
function execute_time() {
	$stime = explode ( ' ', SYS_START_TIME );
	$etime = explode ( ' ', microtime () );
	$r_time=number_format ( ($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6 );
	$r_ram=number_format(memory_get_usage()/1024/1024,4);
	return $r_time.'&nbsp;s&nbsp;&nbsp;&nbsp;'.$r_ram.'MB&nbsp;&nbsp;';
}
