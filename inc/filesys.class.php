<?php
header("Content-type:text/html;charset=utf-8;");

final class filesys{

	/*	function __construct(){

	}

	function __destruct(){

	}*/
	/**
	 * 创建目录
	 * @param unknown_type $dir_name
	 */
	function create_dir($attach_dir){
		if (!file_exists($attach_dir))
		@mkdir($attach_dir,0777);
	}

	/**
	 *
	 * 如果文件夹不存在则创建
	 */
	function create_updir($dir_type,$attach_dir){
		$f=$attach_dir;
		switch ($dir_type)
		{
			case 1:
				self::create_dir($attach_dir);
				break;
			case 2:
				$f=$attach_dir.'/'.date('ym').'/';
				self::create_dir($f);
				break;
			case 3:
				$f=$attach_dir.'/'.date('ymd').'/';
				self::create_dir($f);
				break;
		}
		return $f;
	}

	/**
	 * 生成文件名
	 */
	function file_name(){
		return strtotime('now').mt_rand(1000, 9999);
	}

	function file_ext($t){
		$ext_arr=array("image/jpg"=>"jpg",
		"image/jpeg"=>"jpg",
		"image/pjpeg"=>"jpg",
		"image/gif"=>"gif",
		"image/x-png"=>"png",
		"text/plain"=>"txt",
		"application/msword"=>"doc",
		"application/octet-stream"=>"doc",
		"application/x-shockwave-flash"=>"swf",
		"image/png"=>"png");
		return $ext_arr[$t];
	}

	function upload_error($error){
		$result='';
		switch ($error){
			case 1:
				$result='文件大小超过了PHP.ini中的文件限制！';
				break;
			case 2:
				$result='文件大小超过了浏览器限制！';
				break;
			case 3:
				$result='文件部分被上传！';
				break;
			case 4:
				$result='没有找到要上传的文件！';
				break;
			case 5:
				$result='服务器临时文件夹丢失，请重新上传!';
				break;
			case 6:
				$result='文件写入到临时文件夹出错！';
				break;
		}
		return $result;
	}


	/**
	 *
	 * 查找第一次出现的字符  有则返回位置，无则返回false;
	 * @param $type
	 */
	function upload_type($type){
		//上传类型text/plain--txt,application/x-zip-compressed,application/octet-stream--.zip
		$up_ext='image/jpg,image/jpeg,image/pjpeg,image/gif,image/x-png,image/png,text/plain,application/msword,application/octet-stream,application/x-shockwave-flash';
		$result=strpos($up_ext, $type);
		return $result;
	}

	/**
	 * 删除文件
	 * @param unknown_type $filename
	 * @return boolean
	 */
	function delFile($filename){
		if (file_exists($filename)){
			unlink($filename);
			return true;
		}else {
			return false;
		}
	}

	function read_dir($dir_path){
		$dir_result='';$file_result='';
		if (is_dir($dir_path)){
			if (is_readable($dir_path)){
				$dir_hand=opendir($dir_path);
				while ($r=readdir($dir_hand)){
					if (is_dir($r)){
						$dir_result.="<a href='?d=$r'>$r</a><br>";
					}
					else {
						$file_result.=$r.'<br>';
					}
				}
			}
			else {
				die('该目录不可读！');
			}
		}
		else{
			die('请确定此路径是目录');
		}
		return $dir_result.$file_result;
	}

	function read_file($file_path)
	{
		$result="";
		if (file_exists($file_path) && is_readable($file_path))
		{
			fopen($file_path, "w");
		}
		return $result;
	}

	/**
	 * 以可写的方式打开文件，并把内容写入文件
	 * @param $filename--要写入的文件 $file_data--要写入的文件内容
	 */
	function put_contents($filename,$file_data)
	{
		$result=file_put_contents($filename, $file_data);
		return $result;
	}
	
	/**
	 * 计算文件夹大小
	 * @param unknown_type $dir
	 * @return number
	 */
	function getDirSize($dir)
	{
		$handle = opendir($dir);
		while (false!==($FolderOrFile = readdir($handle)))
		{
			if($FolderOrFile != "." && $FolderOrFile != "..")
			{
				if(is_dir("$dir/$FolderOrFile"))
				{
					$sizeResult += $this->getDirSize("$dir/$FolderOrFile");
				}
				else
				{
					$sizeResult += filesize("$dir/$FolderOrFile");
				}
			}
		}
		closedir($handle);
		return $sizeResult;
	}
	
	// 单位自动转换函数
	function getRealSize($size)
	{
		$kb = 1024;         // Kilobyte
		$mb = 1024 * $kb;   // Megabyte
		$gb = 1024 * $mb;   // Gigabyte
		$tb = 1024 * $gb;   // Terabyte
	
		if($size < $kb)
		{
			return $size." B";
		}
		else if($size < $mb)
		{
			return round($size/$kb,2)." KB";
		}
		else if($size < $gb)
		{
			return round($size/$mb,2)." MB";
		}
		else if($size < $tb)
		{
			return round($size/$gb,2)." GB";
		}
		else
		{
			return round($size/$tb,2)." TB";
		}
	}
	
	
}
?>