<?php
//header('Content-type:image/PNG;charset=utf-8;');
session_start();
final class GD{		
		/*
	* 功能：PHP图片水印 (水印支持图片或文字)
	* 参数：
	*      $groundImage    背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；
	*      $waterPos        水印位置，有10种状态，0为随机位置；
	*                        1为顶端居左，2为顶端居中，3为顶端居右；
	*                        4为中部居左，5为中部居中，6为中部居右；
	*                        7为底端居左，8为底端居中，9为底端居右；
	
	*      $waterImage        图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式；
	*      $waterText        文字水印，即把文字作为为水印，支持ASCII码，不支持中文；
	*      $textFont        文字大小，值为1、2、3、4或5，默认为5；
	*      $textColor        文字颜色，值为十六进制颜色值，默认为#FF0000(红色)；
	*
	* 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG
	*      $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。
	*      当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。
	*      加水印后的图片的文件名和 $groundImage 一样。
	*/
	function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000")
	{
	   $isWaterImage = FALSE;
	   $formatMsg = "暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。";
	
	   //读取水印文件
	   if(!empty($waterImage) && file_exists($waterImage))
	   {
	       $isWaterImage = TRUE;
	       $water_info = getimagesize($waterImage);
	       $water_w    = $water_info[0];//取得水印图片的宽
	       $water_h    = $water_info[1];//取得水印图片的高
	
	       switch($water_info[2])//取得水印图片的格式
	       {
	           case 1:$water_im = imagecreatefromgif($waterImage);break;
	           case 2:$water_im = imagecreatefromjpeg($waterImage);break;
	           case 3:$water_im = imagecreatefrompng($waterImage);break;
	           default:die($formatMsg);
	       }
	   }
	
	   //读取背景图片
	   if(!empty($groundImage) && file_exists($groundImage))
	   {
	       $ground_info = getimagesize($groundImage);
	       $ground_w    = $ground_info[0];//取得背景图片的宽
	       $ground_h    = $ground_info[1];//取得背景图片的高
	
	       switch($ground_info[2])//取得背景图片的格式
	       {
	           case 1:$ground_im = imagecreatefromgif($groundImage);break;
	           case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
	           case 3:$ground_im = imagecreatefrompng($groundImage);break;
	           default:die($formatMsg);
	       }
	   }
	   else
	   {
	       die("需要加水印的图片不存在！");
	   }
	
	   //水印位置
	   if($isWaterImage)//图片水印
	   {
	       $w = $water_w;
	       $h = $water_h;
	       $label = "图片的";
	   }
	   else//文字水印"./cour.ttf"
	   {
	   	   $font_file=dirname(dirname(__FILE__))."/fonts/comic sans ms.ttf";
	       $temp = imagettfbbox(ceil($textFont*5.5),0,"./cour.ttf",$waterText);//取得使用 TrueType 字体的文本的范围
	       $w = $temp[2] - $temp[6];
	       $h = $temp[3] - $temp[7];
	       unset($temp);
	       $label = "文字区域";
	   }
	   if( ($ground_w<$w) || ($ground_h<$h) )
	   {
	       echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！";
	       return;
	   }
	   switch($waterPos)
	   {
	       case 0://随机
	           $posX = rand(0,($ground_w - $w));
	           $posY = rand(0,($ground_h - $h));
	           break;
	       case 1://1为顶端居左
	           $posX = 0;
	           $posY = 0;
	           break;
	       case 2://2为顶端居中
	           $posX = ($ground_w - $w) / 2;
	           $posY = 0;
	           break;
	       case 3://3为顶端居右
	           $posX = $ground_w - $w;
	           $posY = 0;
	           break;
	       case 4://4为中部居左
	           $posX = 0;
	           $posY = ($ground_h - $h) / 2;
	           break;
	       case 5://5为中部居中
	           $posX = ($ground_w - $w) / 2;
	           $posY = ($ground_h - $h) / 2;
	           break;
	       case 6://6为中部居右
	           $posX = $ground_w - $w;
	           $posY = ($ground_h - $h) / 2;
	           break;
	       case 7://7为底端居左
	           $posX = 0;
	           $posY = $ground_h - $h;
	           break;
	       case 8://8为底端居中
	           $posX = ($ground_w - $w) / 2;
	           $posY = $ground_h - $h;
	           break;
	       case 9://9为底端居右
	           $posX = $ground_w - $w;
	           $posY = $ground_h - $h;
	           break;
	       default://随机
	           $posX = rand(0,($ground_w - $w));
	           $posY = rand(0,($ground_h - $h));
	           break;    
	   }
	
	   //设定图像的混色模式
	   imagealphablending($ground_im, true);
	
	   if($isWaterImage)//图片水印
	   {
	       imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件        
	   }
	   else//文字水印
	   {
	       if( !empty($textColor) && (strlen($textColor)==7) )
	       {
	           $R = hexdec(substr($textColor,1,2));
	           $G = hexdec(substr($textColor,3,2));
	           $B = hexdec(substr($textColor,5));
	       }
	       else
	       {
	           die("水印文字颜色格式不正确！");
	       }
	       imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));        
	   }
	
	   //生成水印后的图片
	   @unlink($groundImage);
	   switch($ground_info[2])//取得背景图片的格式
	   {
	       case 1:imagegif($ground_im,$groundImage);break;
	       case 2:imagejpeg($ground_im,$groundImage);break;
	       case 3:imagepng($ground_im,$groundImage);break;
	       default:die($errorMsg);
	   }
	
	   //释放内存
	   if(isset($water_info)) unset($water_info);
	   if(isset($water_im)) imagedestroy($water_im);
	   unset($ground_info);
	   imagedestroy($ground_im);
	}


		
	/**
	 * 缩略图http://www.open-open.com/lib/view/open1337330620354.html
	 * int $width--缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
	 * int $height--缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
	 * int $cut--是否裁切
	 * int/float $proportion--缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
	 */

	function img2thumb($src_img, $dst_img, $width = 360, $height = 260, $cut = 0, $proportion = 0)
	{
	    if(!is_file($src_img))
	    {
	        return false;
	    }
	    $ot = $this->fileext($dst_img);
	    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
	    $srcinfo = getimagesize($src_img);
	    $src_w = $srcinfo[0];
	    $src_h = $srcinfo[1];
	    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
	    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
	
	    $dst_h = $height;
	    $dst_w = $width;
	    $x = $y = 0;
	
	    /**
	     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
	     */
	    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
	    {
	        $proportion = 1;
	    }
	    if($width> $src_w)
	    {
	        $dst_w = $width = $src_w;
	    }
	    if($height> $src_h)
	    {
	        $dst_h = $height = $src_h;
	    }
	
	    if(!$width && !$height && !$proportion)
	    {
	        return false;
	    }
	    if(!$proportion)
	    {
	        if($cut == 0)
	        {
	            if($dst_w && $dst_h)
	            {
	                if($dst_w/$src_w> $dst_h/$src_h)
	                {
	                    $dst_w = $src_w * ($dst_h / $src_h);
	                    $x = 0 - ($dst_w - $width) / 2;
	                }
	                else
	                {
	                    $dst_h = $src_h * ($dst_w / $src_w);
	                    $y = 0 - ($dst_h - $height) / 2;
	                }
	            }
	            else if($dst_w xor $dst_h)
	            {
	                if($dst_w && !$dst_h)  //有宽无高
	                {
	                    $propor = $dst_w / $src_w;
	                    $height = $dst_h  = $src_h * $propor;
	                }
	                else if(!$dst_w && $dst_h)  //有高无宽
	                {
	                    $propor = $dst_h / $src_h;
	                    $width  = $dst_w = $src_w * $propor;
	                }
	            }
	        }
	        else
	        {
	            if(!$dst_h)  //裁剪时无高
	            {
	                $height = $dst_h = $dst_w;
	            }
	            if(!$dst_w)  //裁剪时无宽
	            {
	                $width = $dst_w = $dst_h;
	            }
	            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
	            $dst_w = (int)round($src_w * $propor);
	            $dst_h = (int)round($src_h * $propor);
	            $x = ($width - $dst_w) / 2;
	            $y = ($height - $dst_h) / 2;
	        }
	    }
	    else
	    {
	        $proportion = min($proportion, 1);
	        $height = $dst_h = $src_h * $proportion;
	        $width  = $dst_w = $src_w * $proportion;
	    }
	
	    $src = $createfun($src_img);
	    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
	    $white = imagecolorallocate($dst, 255, 255, 255);
	    imagefill($dst, 0, 0, $white);
	
	    if(function_exists('imagecopyresampled'))
	    {
	        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	    }
	    else
	    {
	        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	    }
	    $otfunc($dst, $dst_img);
	    imagedestroy($dst);
	    imagedestroy($src);
	    return true;
	}
	
	function fileext($file)
	{
	    return pathinfo($file, PATHINFO_EXTENSION);
	}
	
	function createimg($str){
		if (!empty($str)){
			$width=170;
			$height=22;
			$size=12;
			$im=imagecreate($width, $height);
			$red=imagecolorallocate($im, 255, 0, 0);
			$black=imagecolorallocate($im, 255, 255, 255);
			imagefill($im, 0, 0, $black);
			$text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
			//imagestring($im, 5, 0, 0, $str, $red);
			$font_file=dirname(dirname(__FILE__))."/fonts/comic sans ms.ttf";
			@imagefttext($im, $size , 0, 5, $size + 3, $text_color, $font_file, $str);
			imagepng($im);
			imagedestroy($im);
		}
	}

	/**
	 *
	 * 生成简单验证码
	 */
	function smi_code(){
		$num = 4;
		$str = "23456789abcdefghijkmnpqrstuvwxyz";
		$code = '';
		for ($i = 0; $i < $num; $i++) {
			$code .= $str[mt_rand(0, strlen($str)-1)];
		}
		$_SESSION["code"]=$code;
		$im=imagecreate(58, 25);//创建图片
		$red=imagecolorallocate($im, 200, 200, 200);//生成颜色
		$blue=imagecolorallocate($im, 0, 0, 255);
		$black=imagecolorallocate($im,0,0,0);
		imagefill($im, 60, 20, $red);
		imagestring($im, 5, 10, 4, $code, $blue);
		for($i=0;$i<50;$i++)
		{
		imagesetpixel($im, rand()*70, rand()*30, $black);
		}
		imagepng($im);
		imagedestroy($im);
	}
	
	/**
	 * vCode(m,n,x,y) m个数字  显示大小为n   边宽x   边高y
	 * http://blog.qita.in
	 * 自己改写记录session $code
	 */
	
	function ver_code($num = 4, $size = 15, $width = 0, $height = 0) {
		!$width && $width = $num * $size * 4 / 5 + 5;
		!$height && $height = $size + 10;
		// 去掉了 0 1 O l 等
		$str = "23456789abcdefghijkmnpqrstuvwxyz";
		$code = '';
		for ($i = 0; $i < $num; $i++) {
			$code .= $str[mt_rand(0, strlen($str)-1)];
		}
		// 画图像
		$im = imagecreatetruecolor($width, $height);
		// 定义要用到的颜色
		$back_color = imagecolorallocate($im, 235, 236, 237);
		$boer_color = imagecolorallocate($im, 118, 151, 199);
		$text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
		// 画背景
		imagefilledrectangle($im, 0, 0, $width, $height, $back_color);
		// 画边框
		//imagerectangle($im, 0, 0, $width-1, $height-1, $boer_color);
		// 画干扰线
		for($i = 0;$i < 10;$i++) {
			$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagearc($im, mt_rand(- $width, $width), mt_rand(- $height, $height), mt_rand(30, $width * 2), mt_rand(20, $height * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);
		}
		// 画干扰点
		for($i = 0;$i < 300;$i++) {
			$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $font_color);
		}
		//$font_file="c:\\WINDOWS\\Fonts\\simsun.ttc";
		$font_file=dirname(dirname(__FILE__))."/fonts/ariali.ttf";
		// 画验证码
		imagefttext($im, $size , 0, 5, $size + 3, $text_color, $font_file, $code);
		$_SESSION["code"]=$code;
		header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
		header("Content-type: image/png;charset=gb2312");
		imagepng($im);
		imagedestroy($im);
	}
	

	function random($len)
	{
		$srcstr="abcdefghijklmnopqrstuvwxyz123456789";
		$strs="";
		for($j=0;$j<$len;$j++)
		{
			$strs.=$srcstr[mt_rand(0, 35)];
		}
		return $strs;
	}
	
	/**
	 * 获取远程图片并把它保存到本地
	 * @param string $url 是远程图片的完整URL地址，不能为空。
	 * @param $filename 是可选变量: 如果为空，本地文件名将基于时间和日期
	 * @return boolean|string
	 */
	function GrabImage($url,$filename="") {
		if($url==""):return false;endif;
		if($filename=="") {
			$ext=strrchr($url,".");
			if($ext!=".gif" && $ext!=".jpg"):return false;endif;
			$filename=date("dMYHis").$ext;
		}
		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);
		$filename='upload/'.date("ym").'/'.$filename;
		$fp2=@fopen($filename, "a");
		fwrite($fp2,$img);
		fclose($fp2);
		return $filename;
	}
}
?>