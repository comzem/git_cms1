<?php
header("Content-type:text/html;charset=utf-8;");
require dirname(dirname(__FILE__)).'/inc/constant.php';

include 'filesys.class.php';
include 'GD.class.php';
$fcontrol=new filesys();
$gd=new GD();

$inputname='myfile';//file的名称
$attach_dir='../upload';//文件保存路径
$max_upsize=$_CFG['attachment'][0]*1024;//最大上传大小，默认是2M(2097152)
$dir_type=$_CFG['attachment'][4]=='month'?2:3;//目录类型1--直接存入$attach_dir 2--按月存入  3--按天存入
$Thumbnail=1;//1:生成缩略图 0:不生成
$is_small='1';//是否生成缩图 1:是 0:否
$save_name="";$small_name='';$medium_name='';
ini_set('date.timezone', 'Asia/Shanghai');//设置时区
$msg="";
$rand_name='';//随机文件名
$get_name='';//
$parent_name_1="";//返回的文件名
$parent_name_2="";//返回小图文件名
$parent_name_3="";//中图
$parent_target='';//要在父窗口赋值的目标
$smallw=$_CFG['attachment'][2];$smallh=$_CFG['attachment'][3];//缩略图大小

$ext=explode(',', $_CFG['attachment'][1]);//允许
$groundImage="";//要加水印的图片
$img_info=array();

if (isset($_GET['tt'])){
	$is_small=$_GET['tt'];
}
if (isset($_GET['path']) && !empty($_GET['path'])){
	$attach_dir='../'.$_GET['path'];
}
if (isset($_GET['hide'])){
	$parent_target=$_GET['hide'];
}
if (isset($_GET['filename'])){
	$inputname=$_GET['filename'];
}
if (isset($_GET['fname']) && !empty($_GET['fname'])){//传送过来的文件名，如果不为空，则删除此文件及缩略图
	$fname=$_GET['fname'];
	$rand_name=substr($fname,strripos($fname, '/')+1);
	$rand_name=substr($rand_name,0, strpos($rand_name, '.'));
	$deletepath=str_replace('upload', '', $fname);
	$deletepath=substr($deletepath, strripos($deletepath, '/')+1);

	$fcontrol->delFile($attach_dir.$deletepath);//原图
	$fcontrol->delFile($attach_dir.$deletepath.'s');//小图
	$fcontrol->delFile($attach_dir.$deletepath.'m');//中图如会员头像
}



if (isset($_GET['w']) && isset($_GET['h'])){
	$smallw=C::isint($_GET['w']);$smallh=C::isint($_GET['h']);
}
$waterImage="../images/watermark.gif";
$waterText=$_CFG['water'][4];

$up_ext="";
if (isset($_FILES) && is_array($_FILES[$inputname]['name']))
{
	$f_arr=$_FILES[$inputname]['name'];
	for($i=0;$i<count($f_arr);$i++)
	{
		if (!empty($f_arr[$i]))
		{
			if ($_FILES[$inputname]['error'][$i]>0){
				$err=$fcontrol->upload_error($_FILES[$inputname]['error'][$i]);
				$msg=$err;
			}
			else{
				$rand_name=empty($rand_name)?$fcontrol->file_name():$rand_name;
				$up_ext=$fcontrol->file_ext($_FILES[$inputname]['type'][$i]);//返回当前上传的文件格式
				if(in_array($up_ext, $ext) && $_FILES[$inputname]['size'][$i]<$max_upsize){
					$save_name=$small_name=$medium_name=$fcontrol->create_updir($dir_type,$attach_dir);
					$save_name.=$rand_name;//生成随机文件名
					
					$small_name.=$rand_name.'s';//生成随机缩略图文件名
					$medium_name.=$rand_name.'m';
					if (!file_exists($save_name.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]))){
						move_uploaded_file($_FILES[$inputname]['tmp_name'][$i], $save_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]));
						$groundImage=$save_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]);
						$parent_name_1.='|'.str_replace("../", "", $save_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]));
						//生成缩略图
							if ($is_small=="1"){
								$gd->img2thumb($save_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]),$small_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]),$smallw,$smallh);
								$parent_name_2.='|'.str_replace("../", "", $small_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]));
							}else if($is_small=="2"){
								$gd->img2thumb($save_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]),$medium_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]),$smallw,$smallh);
								$parent_name_3.='|'.str_replace("../", "", $medium_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]));
								$gd->img2thumb($save_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]),$small_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]),160,160);
								$parent_name_2.='|'.str_replace("../", "", $small_name.'.'.$fcontrol->file_ext($_FILES[$inputname]['type'][$i]));
							}
					}
					else{
						$msg='已存在相同名称的文件！';
					}
				}
				else{
					$msg='文件类型不正确，或超出了文件大小。';
				}
			}
		}
	}
}
if (empty($msg))
{
	//添加水印
	if ($_CFG['water'][0]>0 && !empty($groundImage)){		
		$img_info=getimagesize($groundImage);
		if ($img_info[0]>$_CFG['water'][1] && $img_info[1]>$_CFG['water'][2]){
			if ($_CFG['water'][3]=='1')
				$gd->imageWaterMark($groundImage,$_CFG['water'][0],$waterImage,'');
			else 
				$gd->imageWaterMark($groundImage,$_CFG['water'][0],'',$waterText);
		}
	}
	
	if ($is_small!="0"){
		$parent_name_1=$parent_name_2;
	}
	$parent_name_1=!empty($parent_name_1)?substr($parent_name_1, 1):"";
	$parent_name_2=!empty($parent_name_2)?substr($parent_name_2, 1):"";
	if (empty($parent_target))
	echo "<script>parent.say('".$parent_name_2."','".$parent_name_2."')</script>";
	else
	echo "<script>parent.say('".$parent_name_1."','".$parent_target."')</script>";
}
else
echo "<script>alert('".$msg."')</script>";


?>