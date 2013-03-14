<?php
header("Content-Type:text/html;charset=utf-8");
class common{

	/**
	 * 字符截取 支持UTF8/GBK
	 * @param $string
	 * @param $length
	 * @param $dot
	 */
	public static function StrCut($string, $length, $dot = '...') {
		$strlen = strlen($string);
		if($strlen <= $length) return $string;
		$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
		$strcut = '';
		if(strtolower(CHARSET) == 'utf-8') {
			$length = intval($length-strlen($dot)-$length/3);
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t <= 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
			$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
		} else {
			$dotlen = strlen($dot);
			$maxi = $length - $dotlen - 1;
			$current_str = '';
			$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
			$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
			$search_flip = array_flip($search_arr);
			for ($i = 0; $i < $maxi; $i++) {
				$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
				if (in_array($current_str, $search_arr)) {
					$key = $search_flip[$current_str];
					$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
				}
				$strcut .= $current_str;
			}
		}
		return $strcut.$dot;
	}

	/**
	 * @param unknown_type $str
	 * @param unknown_type $num
	 */
	public static function LeftStr($str,$num)
	{
		$result=($str);
		$str_len=strlen($result);
		if ($str_len>$num)
		{
			$result=mb_substr($str,0,$num,'utf-8');
		}
		//$result=addcslashes($result, count($result));
		return $result;
	}

	/**
	 * 返回经addslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	public static function new_addslashes($string){
		if(!is_array($string)) return addslashes($string);
		foreach($string as $key => $val) $string[$key] = new_addslashes($val);
		return $string;
	}

	/**
	 * 返回经stripslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	public static function new_stripslashes($string) {
		if(!is_array($string)) return stripslashes($string);
		foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
		return $string;
	}

	/**
	 * 返回经htmlspecialchars处理过的字符串或数组
	 * @param $obj 需要处理的字符串或数组
	 * @return mixed
	 */
	public static function new_html_special_chars($string) {
		if(!is_array($string)) return htmlspecialchars($string);
		foreach($string as $key => $val) $string[$key] = new_html_special_chars($val);
		return $string;
	}

	/**
	 * 获取客户端IP
	 * bool isset(mixed var [,mixed var[...]])
	 */
	public static function GetIp()
	{
		$unknown='unknown';
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'],$unknown))
		{
			$clientIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],$unknown))
		{
			$clientIp=$_SERVER['REMOTE_ADDR'];
		}
		return $clientIp;
	}
	/**
	 * 获取请求ip
	 *
	 * @return ip地址
	 */
	public static function ip() {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
	}
	public static function htmlRepace($str)
	{
		if ($str==null)
		return $str;
		$str=str_replace(".", "．",$str);
		$str=str_replace("%", "％",$str);
		$str=str_replace("&", "＆",$str);
		$str=str_replace("@", "＠",$str);
		$str=str_replace("~", "～",$str);
		$str=str_replace("^", "＾",$str);
		$str=str_replace("(", "（",$str);
		$str=str_replace(")", "）",$str);
		$str=str_replace("-", "－",$str);
		$str=str_replace("+", "＋",$str);
		$str=str_replace("=", "＝",$str);
		$str=str_replace("/", "／",$str);
		$str=str_replace("*", "＊",$str);
		$str=str_replace("[", "［",$str);
		$str=str_replace("]", "］",$str);
		$str=str_replace("'", "＇",$str);
		return $str;
	}

	public static function noHtmlRepace($str)
	{
		$str=str_replace("．", ".",$str);
		$str=str_replace("％", "%",$str);
		$str=str_replace("＆", "&",$str);
		$str=str_replace("＠", "@",$str);
		$str=str_replace("～", "~",$str);
		$str=str_replace("＾", "^",$str);
		$str=str_replace("（", "(",$str);
		$str=str_replace("）", ")",$str);
		$str=str_replace("－", "-",$str);
		$str=str_replace("＋", "+",$str);
		$str=str_replace("＝", "=",$str);
		$str=str_replace("／", "/",$str);
		$str=str_replace("＊", "*",$str);
		$str=str_replace("［", "[",$str);
		$str=str_replace("］", "]",$str);
		$str=str_replace("＇", "'",$str);
		return $str;
	}


	public static function isint($str)
	{
		$result=0;
		try {
			$result=(int)$str;
		}
		catch (Exception $ex)
		{
			$result=0;
		}
		return $result;
	}

	/**
	 * 格式化文本域内容
	 *
	 * @param $string 文本域内容
	 * @return string
	 */
	function trim_textarea($string) {
		$string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
		return $string;
	}

	/**
	 * 将文本格式成适合js输出的字符串
	 * @param string $string 需要处理的字符串
	 * @param intval $isjs 是否执行字符串格式化，默认为执行
	 * @return string 处理后的字符串
	 */
	function format_js($string, $isjs = 1) {
		$string = addslashes(str_replace(array("\r", "\n", "\t"), array('', '', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}

	public static function isfloat($str)
	{
		$result=0;
		try {
			$result=(float)$str;
		}
		catch (Exception $ex)
		{
			$result=0.00;
		}
		return $result;
	}

	/**
	 * 程序执行时间
	 *
	 * @return	int	单位ms
	 */
	public static function execute_time() {
		$stime = explode ( ' ', SYS_START_TIME );
		$etime = explode ( ' ', microtime () );
		$r_time=number_format ( ($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6 );
		$r_ram=number_format(memory_get_usage()/1024/1024,4);
		return $r_time.'&nbsp;s&nbsp;&nbsp;&nbsp;'.$r_ram.'MB&nbsp;&nbsp;';
	}


	/**
	 * 把关联数组的key分割成一维数组
	 * @param unknown_type $data
	 */
	public static function keyArray($data){
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
	public static function valueArray($data){
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
	public static function saveString($data){
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
	public static function addAllValue($data){
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
	public static function getCheckbox($val){
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
	 * 安全过滤函数
	 *
	 * @param $string
	 * @return string
	 */
	public static function safe_replace($string) {
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('%2527','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace('"','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace("{",'',$string);
		$string = str_replace('}','',$string);
		$string = str_replace('\\','',$string);
		return $string;
	}
	/**
	 * 获取当前页面完整URL地址
	 */
	public static function get_url() {
		$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER['PHP_SELF'] ? self::safe_replace($_SERVER['PHP_SELF']) : self::safe_replace($_SERVER['SCRIPT_NAME']);
		$path_info = isset($_SERVER['PATH_INFO']) ? self::safe_replace($_SERVER['PATH_INFO']) : '';
		$relate_url = isset($_SERVER['REQUEST_URI']) ? self::safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.self::safe_replace($_SERVER['QUERY_STRING']) : $path_info);
		return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}
	/**
	 * 判断email格式是否正确
	 * @param $email
	 */
	public static function is_email($email) {
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
	}

	public static function session_decode($string){
		$b=strpos($string, '"');
		$e=strrpos($string, '"');
		$string=mb_substr($string, $b+1, $e-1, 'utf-8');
		return self::_authcode($string);
	}

	/**
	 * 字符串加密解密
	 * @param unknown_type $string
	 * @param unknown_type ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE
	 * @param unknown_type $key
	 * @param unknown_type $expiry
	 * @return string
	 */
	public static function _authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
		$ckey_length = 4;

		$key = md5($key ? $key : WEB_KEY);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}

	}

	/**
	 * $_REQUEST key,value
	 * Enter description here ...
	 * @param unknown_type $k
	 * @param unknown_type $var
	 */
	public static function get($k,$var='R'){
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
	public static function msg($msg,$url,$blank=''){
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

	public static function implot($str){
		if (empty($str) || !isset($str)){
			return $str;
		}else{
			return implode(',', $str);
		}
	}

	public static function shapwd($str){
		if (empty($str) || $str===null){
			return null;
		}else{
			return sha1($str);
		}
	}

	/**
	 * 获取分类值
	 * Enter description here ...
	 */
	public static function classify_exp(){
		$add_sort=C::get('add_sort');
		$add_title=C::get('add_title');
		$add_upid=C::get('add_upid');
		$count_add=count($add_sort);
		$data=array();
		for($i=0;$i<$count_add;$i++){
			if (isset($add_title[$i]) && !empty($add_title[$i])){
				$data[]=array(
						"title"=>C::LeftStr($add_title[$i],50),
						"upid"=>$add_upid[$i]=='0'?0:C::isint($add_upid[$i]),
						"sort"=>C::isint($add_sort[$i])
				);
			}else{
				$msg='请填写完整';
				return $msg;
			}
		}
		return $data;
	}

	/**
	 *查找分类
	 */
	public static function getclass($t){
		$gtype=new model($t);
		$field='fid,title,upid,sort';
		$arr_1=$gtype->where('upid=0')->order('sort asc,fid asc')->select($field);
		$nav=array();
		if (is_array($arr_1))
		{
			foreach ($arr_1 as $row_1)
			{
				$sub_0=array();
				if ($gtype->where('upid='.$row_1['fid'])->getField($field)>0){
					$arr_2=$gtype->where('upid='.$row_1['fid'])->select($field);
					foreach ($arr_2 as $row_2){
						$sub_1=array();
						if ($gtype->where('upid='.$row_2['fid'])->getField($field)>0){
							$arr_3=$gtype->where('upid='.$row_2['fid'])->select($field);
							foreach ($arr_3 as $row_3){
								$sub_1[]=array('fid'=>$row_3['fid'],
										'title'=>$row_3['title'],
										'upid'=>$row_3['upid'],
										'sort'=>$row_3['sort']);
							}
						}
						$sub_0[]=array('fid'=>$row_2['fid'],
								'title'=>$row_2['title'],
								'upid'=>$row_2['upid'],
								'sort'=>$row_2['sort'],'sub1'=>$sub_1);
					}
				}
				$nav[]=array('fid'=>$row_1['fid'],
						'title'=>$row_1['title'],
						'upid'=>$row_1['upid'],
						'sort'=>$row_1['sort'],
						'sub'=>$sub_0);
			}
		}
		return $nav;
	}

	/**
	 * 绑定分类到<select/>
	 * Enter description here ...
	 */
	public static function selectf($t){
		$gtype=new model($t);
		$field='fid,title,upid,sort';
		$arr_1=$gtype->where('upid=0')->select($field);
		$nav=array();
		$_classify='';
		if (is_array($arr_1))
		{
			foreach ($arr_1 as $row_1)
			{
				$sub_0=array();
				if ($gtype->where('upid='.$row_1['fid'])->getField($field)>0){
					$arr_2=$gtype->where('upid='.$row_1['fid'])->select($field);
					foreach ($arr_2 as $row_2){
						$sub_1=array();
						if ($gtype->where('upid='.$row_2['fid'])->getField($field)>0){
							$arr_3=$gtype->where('upid='.$row_2['fid'])->select($field);
							foreach ($arr_3 as $row_3){
								$sub_1+=array($row_3['fid']=>$row_3['title']);
							}
							$sub_0+=array($row_2['title']=>$sub_1);
						}else{
							$sub_0+=array($row_2['fid']=>$row_2['title']);
						}
					}
					$nav+=array($row_1['title']=>$sub_0);
				}else{
					$nav+=array($row_1['fid']=>$row_1['title']);
				}

			}
		}
		return $nav;
	}
}
class C extends common{};
?>