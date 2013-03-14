<?php
include dirname(__FILE__).'/inc/init_cms.php';

$aa=tabstatus('cms_ad');
//var_dump($aa);
//echo $aa['Avg_row_length'];
$var=29.6;
//echo is_float($var);
$var=intval($var);
//echo $var;
//packDownload();
//unzip();
//download('aa_20130308_111729.zip');
$dir=ROOT_PATH.'backup/databack/';
$zip_filename = $dir."db_20130308_133207.zip";
$a=pathinfo($zip_filename);
//var_dump($a);
$p='cms_single_classify.sql';
echo substr($p,0,strripos($p, '.'));
function tabstatus($table){
	$mydb=new model('');
	$result=$mydb->query('show table status');
	$arr=array();
	for($i=0;$i<count($result);$i++){
		$arr[$result[$i]['Name']]=$result[$i];
	}
	return $arr[$table];
}

function packDownload()
{
	$dir=ROOT_PATH.'backup/databack';
	$ctrlRes=array('cms_goods_0.sql','cms_goods_1.sql');
	$fPrefix='aa';
	if(class_exists('ZipArchive'))
	{
		$fileName = $fPrefix.'_'.date('Ymd_His').'.zip';
		$zip = new ZipArchive();
		$zip->open($dir.'/'.$fileName,ZIPARCHIVE::CREATE);
		foreach($ctrlRes as $file)
		{
			$attachfile = $dir.'/'.$file;
			$zip->addFile($attachfile,basename($attachfile));
		}
		$zip->close();

		return $fileName;
	}
	else
	{
		return false;
	}
}

function download($file)
{
	$dir=ROOT_PATH.'backup/databack';
	header('Content-Description: File Transfer');
	header('Content-Length: '.filesize($dir.'/'.$file));
	header('Content-Disposition: attachment; filename='.basename($file));
	readfile($dir.'/'.$file);
	return $dir.'/'.$file;
}

function unzip(){
	set_time_limit(0);
	$dir=ROOT_PATH.'backup/databack';
	$zip_filename = "db_20130308_133207.zip";
	//$zip_filename = key_exists(zip, $_GET) && $_GET[zip]?$_GET[zip]:$zip_filename;
	$dir=ROOT_PATH.'backup/databack';
	$zip_filepath=$dir.'/'.$zip_filename;
	if(!is_file($zip_filepath))
	{
		die("文件".$zip_filepath."不存在!");
	}
	$zip = new ZipArchive();
	$rs = $zip->open($zip_filepath);
	if($rs !== TRUE)
	{
		die("解压失败!Error Code:". $rs);
	}
	$zip->extractTo($dir);
	$zip->close();
	echo $zip_filename."解 压成功!";
}
