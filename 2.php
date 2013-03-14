<?php
//include dirname(__FILE__).'/inc/init_cms.php';
postmail('592223997@qq.com','你好','你好...');
function postmail($to,$subject = "",$body = ""){
	date_default_timezone_set("Asia/Shanghai");
	require 'phpmailer/class.phpmailer.php';
	require 'phpmailer/class.smtp.php';
	$mail             = new PHPMailer(); //new一个PHPMailer对象出来
	//$body             = preg_replace("[\]",'',$body); //对邮件内容进行必要的过滤
	$mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP(); // 设定使用SMTP服务
	$mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
	// 1 = errors and messages
	// 2 = messages only
	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
	//$mail->SMTPSecure = "ssl";                 // 安全协议
	$mail->Host       = "smtp.126.com";      // SMTP 服务器
	$mail->Port       = 25;                   // SMTP服务器的端口号
	$mail->Username   = "comzem";  // SMTP服务器用户名
	$mail->Password   = "chj862563";            // SMTP服务器密码
	$mail->SetFrom('comzem@126.com', '谢先生');
	$mail->AddReplyTo("comzem@126.com","谢先生");
	$mail->Subject    = $subject;
	$mail->AltBody    = "text/html"; // optional, comment out and test
	$mail->MsgHTML($body);
	$address = $to;
	$mail->AddAddress($address, "谢先生");
	//$mail->AddAttachment("images/phpmailer.gif");      // attachment
	//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!恭喜，邮件发送成功！";
	}
}
