<?php
class tools{
	private $dir = 'backup/database'; //备份路径
	public function mydb(){
		$mydb=new model('');
		$result=$mydb->query('show table status');
		$smarty=new Smarty();
		$t=get('t');
		$tmp='';
		$arr=array();
		if ($t=='optimize'){
			foreach ($result as $row){
				if ($row['Data_free']>0){
					$arr[]=array(
							'Name'=>$row['Name'],
							'Rows'=>$row['Rows'],
							'Data_length'=>$row['Data_length'],
							'Update_time'=>$row['Update_time'],
							'Data_free'=>$row['Data_free']
							);
				}
			}
			$tmp='_optimize';
		}else{
			$arr=$result;
		}
		$data=array(
				'list'=>$arr,
				'foot_msg'=>C::execute_time());
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH."mydb$tmp.htm");
	}

	function bak(){
		$this->dbback();
		//$this->dbstruct();
	}
	

	/**
	 * 备份数据结构
	 * Enter description here ...
	 * @param unknown_type $tablename
	 */
	function dbstruct(){
		$tablename=get('check_id');
		$struct_bak='';
		$mydb=new model('');
		for($i=0;$i<count($tablename);$i++){
			$struct=$mydb->query('show create table '.$tablename[$i]);
			//表名
			$tab=$struct[0]['Table'];
			//结构语句
			$sql=$struct[0]['Create Table'];
			$struct_bak.="\n".$sql."\n";
		}
		file_put_contents('./backup/databack/struct_'.time().'.sql', $struct_bak);
	}
	
	
	/**
	 * 备份数据
	 * Field,Type,Collation,Null,Key,Default,Extra,Privileges,Comment
	 * @param $tablename
	 */
	function dbback(){
		$tablename=get('check_id');
		$mydb=new model('');
		$field='';
		$sql='';
		$limit_size=get('limit_size');
		
		if ($limit_size===null || $limit_size<0){
			msg('请填写正确的尺寸', '-1');
			exit(0);
		}
		for ($i=0;$i<count($tablename);$i++){
			$columninfo=$mydb->query('SHOW FULL COLUMNS FROM '.$tablename[$i]);	
					
			$sql.="insert into $tablename[$i](";
			for($j=0;$j<count($columninfo);$j++){
				$field.=','.$columninfo[$j]['Field'];
			}
			$field=substr($field, 1);
			$sql.=$field.") values ";
			$this->select_data($limit_size,$sql,$tablename[$i])."\n";
			$sql='';
			$columninfo=array();
			$field='';
			
		}
		msg('', '-1');
		//C::msg('', '/source/redirect.php?msg=数据备份完成&url='.urlencode($_SERVER['HTTP_REFERER']));
		//echo $sql;
	}
	
	//生成语句
	function select_data($limit_size,$_cachesql,$table){
		$mydb=new model('');
		
		//返回字段信息
		$field=array();
		$columninfo=$mydb->query("SHOW FULL COLUMNS FROM $table");
		for($i=0;$i<count($columninfo);$i++){
			$field+=array($columninfo[$i]['Field']=>$columninfo[$i]['Type']);
		}
		
		//返回表信息
		$tb_status=$this->tabstatus($table);
		$rows=$tb_status['Rows'];//行数
		$avg_row_length=$tb_status['Avg_row_length'];//行平均尺寸
		$data_length=$tb_status['Data_length'];//表尺寸
				
		/*if ($data_length>$limit_size*1024 && $rows>0){
			//按尺寸算出每卷行数
			$limit=($limit_size*1024)/$avg_row_length;
			
			//计算出多少卷
			$juan=$rows/$limit;
			if (is_float($juan)){
				$juan=intval($juan)+1;
			}
			if (is_float($limit)){
				$limit=intval($limit);
			}			
			$sql='';
			
			for ($s=0;$s<$juan;$s++){
				$sql="select * from $table where 1=1 limit ".$s*$limit.",$limit";
				$arr=$mydb->query($sql);
				$sqlbak='';
				$j=0;
				if (count($arr)<=0){
					return '';
				}
				for($i=0;$i<count($arr);$i++){
					$result='';
					foreach ($arr[$i] as $k=>$v){//$k:field,$v:值
						$result.=','.$this->field_type($field[$k],$v);
					}
					$result=substr($result, 1);
					$sqlbak.=",($result)";
				
				}			
				file_put_contents('./backup/databack/'.$table.'_'.$s.'.sql', $_cachesql.substr($sqlbak, 1));
			}
		}else{*/
			$sql="select * from $table";
			$arr=$mydb->query($sql);
			$sqlbak='';
			$j=0;
			if (count($arr)<=0){
				return '';
			}
			for($i=0;$i<count($arr);$i++){
				$result='';
				foreach ($arr[$i] as $k=>$v){//$k:field,$v:值
					$result.=','.$this->field_type($field[$k],$v);
				}
				$result=substr($result, 1);
				$sqlbak.=",($result)";
			
			}
			file_put_contents('./backup/databack/'.$table.'.sql', $_cachesql.substr($sqlbak, 1));
		//}
		
		

		
		
		//return substr($sql, 1);
	}
	
	//判断类型
	function field_type($type,$value){
		$sqltype=array('bigint','binary','bit','blob','bool','boolean','char','date','datetime','decimal','double','enum','float','int','longblob','longtext','mediumblob',
				'mediumint','mediumtext','numeric','real','set','smallint','text','time','timestamp','tinyblob','tinyint','tinytext','varbinary','varchar','year');
		$sqltype1=array('char','enum','longtext','mediumtext','set','text','tinytext','varchar');
		$result='';
		if (strpos($type, '(')){
			$type=substr($type,0, strpos($type, '('));//截取字段类型
		}
		if (in_array($type, $sqltype1)){
			$result='\''.$value.'\'';
		}else{
			$result=$value;
		}
		return $result;
	}
	
	//返回表信息
	function tabstatus($table){
		$mydb=new model('');
		$result=$mydb->query('show table status');
		$arr=array();
		for($i=0;$i<count($result);$i++){
			$arr[$result[$i]['Name']]=$result[$i];
		}
		return $arr[$table];
	}

	/**
	 * 显示最后一个执行的语句所产生的错误、警告和通知
	 * Level Code Message
	 */
	function dbwarning(){
		$mydb=new model('');
		$warn=$mydb->query('show warnings');
	}
	
	/**
	 * 读取备份文件
	 */
	function restoreview(){
		global $smarty;
		require COMMON.'filesys.class.php';
		$f=new filesys();
		$dir=ROOT_PATH.'backup/databack';
		$dir_hand=opendir($dir);
		//读取目录
		$result=array();
		while ($r=readdir($dir_hand)){
			if ($r!='.' && $r!='..'){
				$filemsg=pathinfo($dir.'/'.$r);
				$result[]=array(
						'name'=>$r,
						'filesize'=>$f->getRealSize(filesize($dir.'/'.$r)),
						'time'=>filemtime($dir.'/'.$r),
						'ext'=>$filemsg['extension']
						);
			}
		}
		$iszip='';
		if(!class_exists('ZipArchive')){
			$iszip="<span style='color:#ff0000;'>服务器不支持压缩？</span>";
		}
		$smarty->assign('iszip',$iszip);
		$smarty->assign('list',$result);
		$smarty->display(DEFAUTL_PATH.'mydb_restore.htm');
	}

	/**
	 * 恢复数据 ajax
	 * Enter description here ...
	 */
	function dbrestore(){
		//清空数据表
		$mydb=new model('');
		$bakname=get('check_id');
		$dir=ROOT_PATH.'backup/databack/';
		if (is_array($bakname)){
			for($i=0;$i<count($bakname);$i++){
				$sql='';
				//清空数据
				$p=$bakname[$i];
				//$p=substr($p,strripos($p, PRE)+strlen(PRE));
				$p=substr($p,0,strripos($p, '.'));
				$mydb->execute('TRUNCATE '.$p);
				//开始恢复数据
				$sql=file_get_contents($dir.$bakname[$i]);
				$mydb->execute($sql);
			}
		}else{
			$p=$bakname;
			$p=substr($p,0,strripos($p, '.'));
			$mydb->execute('TRUNCATE '.$p);
			$sql=file_get_contents($dir.$bakname);
			$mydb->execute($sql);
		}	
		msg('', '/source/redirect.php?msg=恢复数据完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	function bakdel(){
		$file=get('file');
		$dir=ROOT_PATH.'backup/databack/';
		if (file_exists($dir.$file)){
			unlink($dir.$file);
		}
		msg('', '-1');
	}
	
	function dbfiledel(){
		$filename=get('check_id');
		$dir=ROOT_PATH.'backup/databack/';
		for ($i=0;$i<count($filename);$i++){			
			if (file_exists($dir.$filename[$i])){
				unlink($dir.$filename[$i]);
			}
		}
		msg('', '/source/redirect.php?msg=文件删除完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	/**
	 * 修复被破坏的表
	 * Enter description here ...
	 * @param unknown_type $tablename
	 */
	function repair($tablename){
		$mydb=new model('');
		$mydb->query('REPAIR TABLE '.$tablename);
	}

	/**
	 * 优化表,对表进行碎片整理
	 * Enter description here ...
	 * @param $tablename
	 */
	function optimize(){
		$mydb=new model('');
		$tablename=get('check_id');
		if ($tablename===null){
			msg('请选择表！', '-1');
			exit(0);
		}
		for ($i=0;$i<count($tablename);$i++){
			$mydb->execute('OPTIMIZE TABLE '.$tablename[$i]);
		}
		msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	//打包并下载
	function packzip(){
		$pack=$this->packDownload();
		$this->download($pack);
	}

	//文件打包
	function packDownload()
	{
		$dir=ROOT_PATH.'backup/databack';
		$tab=get('check_id');
		if ($tab===null){
			msg('请选择文件', '-1');
			exit(0);
		}
		$ctrlRes=$tab;
		$fPrefix='db';
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
			msg('ZipArchive不存在，无法压缩文件！', '-1');
			return false;
		}
	}
	
	//解压zip
	function unzip(){
		set_time_limit(0);
		$dir=ROOT_PATH.'backup/databack';
		$zip_filename = get('filepath');
		$dir=ROOT_PATH.'backup/databack';
		$zip_filepath=$dir.'/'.$zip_filename;
		if(!is_file($zip_filepath))
		{
			msg("文件".$zip_filepath."不存在!",'-1');
		}
		$zip = new ZipArchive();
		$rs = $zip->open($zip_filepath);
		if($rs !== TRUE)
		{
			die("解压失败!Error Code:". $rs);
		}
		$zip->extractTo($dir);
		$zip->close();
		C::msg('', '/source/redirect.php?msg='.$zip_filename.'解 压成功!&url='.urlencode($_SERVER['HTTP_REFERER']));
	}


	/**
	 * 下载文件
	 * Enter description here ...
	 * @param unknown_type $file
	 */
	function download($file)
	{
		header('Content-Description: File Transfer');
		header('Content-Length: '.filesize($this->dir.'/'.$file));
		header('Content-Disposition: attachment; filename='.basename($file));
		readfile($this->dir.'/'.$file);
		return $this->dir.'/'.$file;
	}

	/**
	 * 修改mysql 密码
	 * Enter description here ...
	 * @param $pw
	 */
	function password($pw){
		$mydb=new model('');
		$mydb->query('UPDATE mysql.user SET password=PASSWORD(’新密码’) WHERE User=’’');
		$mydb->query('FLUSH PRIVILEGES');
	}

	/**
	 * 查找城市
	 * Enter description here ...
	 */
	public function area(){
		$area=new model('areas');
		$field='`area_id`,`area_name`';
		$data=$area->where('`parent_id`=0')->order('`sort` asc,`area_id` asc')->select($field);
		$result=array(''=>'请选择...');
		foreach ($data as $row){
			$result+=array(
					$row['area_name']=>$row['area_name']
			);
		}
		return $result;
	}

	/**
	 * 导航设置
	 * Enter description here ...
	 */
	public function nav(){
		$gtype=new model('nav');
		$smarty=new Smarty();
		$fid=get('fid');
		if ($fid===null){
			return '';
		}
		$field='fid,title,urls,upid,sort,target';
		$arr_1=$gtype->where('upid='.$fid)->select($field);
		$nav=array();
		if (is_array($arr_1))
		{
			foreach ($arr_1 as $row_1)
			{
				$sub_0=array();
				if ($gtype->where('upid='.$row_1['fid'])->getField($field)>0){
					$arr_2=$gtype->where('upid='.$row_1['fid'])->select($field);
					foreach ($arr_2 as $row_2){
						$sub_0[]=array('fid'=>$row_2['fid'],
								'title'=>$row_2['title'],
								'urls'=>$row_2['urls'],
								'upid'=>$row_2['upid'],
								'sort'=>$row_2['sort'],
								'target_options'=>array('_blank'=>''),
								'target'=>$row_2['target']);
					}
				}
				$nav[]=array('fid'=>$row_1['fid'],
						'title'=>$row_1['title'],
						'urls'=>$row_1['urls'],
						'upid'=>$row_1['upid'],
						'sort'=>$row_1['sort'],
						'target_options'=>array('_blank'=>''),
						'target'=>$row_1['target'],
						'sub'=>$sub_0);
			}
		}
		$data=array(
				'tab'=>'?action=tools&operation=addnav',
				'nav'=>$nav,
				'fid'=>$fid);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'nav.htm');
	}

	public function addnav(){
		//保存
		$add_sort=get('add_sort');
		$add_title=get('add_title');
		$add_upid=get('add_upid');
		$add_urls=get('add_urls');
		//$add_blank=get('add_target');
		$count_add=count($add_sort);
		$data=array();
		for($i=0;$i<$count_add;$i++){
			if (isset($add_title[$i]) && !empty($add_title[$i]) && isset($add_urls[$i]) && !empty($add_urls[$i])){
				$data[]=array(
						"title"=>C::LeftStr($add_title[$i],50),
						"upid"=>empty($add_upid[$i])?0:C::isint($add_upid[$i]),
						"sort"=>C::isint($add_sort[$i]),
						'urls'=>C::LeftStr($add_urls[$i],255),
						'target'=>(get("add_target($i)"))===null?'_self':(get("add_target($i)"))
				);
			}else{
				$msg='请填写完整';
			}
		}
		$nav=new model('nav');
		if (!empty($data))
			$result=$nav->data($data)->addAll();
		
		//更新
		$add_fid=get('edit_fid');
		$add_sort=get('edit_sort');
		$add_title=get('edit_title');
		$add_upid=get('edit_upid');
		$add_urls=get('edit_urls');
		//$add_blank=get('edit_target');
		$count_add=count($add_sort);
		for($i=0;$i<$count_add;$i++){
			if (isset($add_title[$i]) && !empty($add_title[$i]) && isset($add_urls[$i]) && !empty($add_urls[$i])){
				$data=array(
						"title"=>C::LeftStr($add_title[$i],50),
						"upid"=>empty($add_upid[$i])?0:C::isint($add_upid[$i]),
						"sort"=>C::isint($add_sort[$i]),
						'urls'=>C::LeftStr($add_urls[$i],255),
						'target'=>(get("edit_target($add_fid[$i])"))===null?'_self':getCheckbox(get("edit_target($add_fid[$i])"))
				);
				$nav->data($data)->where('fid='.$add_fid[$i])->save();
			}else{
				$msg='请填写完整';
			}
		}
				
		C::msg('', $_SERVER['HTTP_REFERER']);
	}
	
	public function navdel(){
		$nav=new model('nav');
		if (isset($_GET['upid'])){
			$upid=get('upid');
			$nav->where('upid='.$upid.'')->delete();
			$nav->where('fid='.$upid)->delete();
		}elseif (isset($_GET['fid'])){
			$fid=get('fid');
			$nav->where('fid='.$fid)->delete();
		}
		C::msg('', $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 商品扩展属性
	 * Enter description here ...
	 */
	public function expand(){
		$exp1=new model('expand');
		$smarty=new Smarty();
		$field='fieldid,available,title,description,formtype,size,choices,validate,sort,style';
		$arr=$exp1->select($field);
		$data=array('tab'=>'?action=product&operation=save_exp1','list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'expend1.htm');
	}
	
	/**
	 * 保存扩展属性
	 * Enter description here ...
	 */
	public function save_exp(){
		$exp1=new model('expand');
		$fieldid=C::get('fieldid');
		$title=C::get('title');
		$description=C::get('description');
		$formtype=C::get('formtype');
		$size=C::get('size');
		$choices=C::get('choices');
		$sort=C::get('sort');
		$style=C::get('style');
	
		$total=count($fieldid);
		$data=array();
		for($i=0;$i<$total;$i++){
			if (!empty($fieldid[$i]) && !empty($title[$i]) && !empty($sort[$i])){
				$data[]=array(
						"fieldid"=>C::LeftStr($fieldid[$i],255),
						"title"=>C::LeftStr($title[$i],255),
						"description"=>C::LeftStr($description[$i],255),
						"formtype"=>C::LeftStr($formtype[$i],12),
						"size"=>C::isint($size[$i]),
						"choices"=>$choices[$i],
						"sort"=>C::isint($sort[$i]),
						"style"=>C::LeftStr($style[$i],10),
				);
			}else{
				$msg='请填写完整';
			}
		}
		var_dump($data);
		$exp1->data($data)->addAll();
		C::msg('', '/lib/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	/**
	 * 
	 * @param unknown_type $to 收件人地址
	 * @param unknown_type $subject 主题
	 * @param unknown_type $body 内容
	 * $toname 收件人名称
	 */	
	function postmail($to,$toname,$subject = "",$body = ""){
		date_default_timezone_set("Asia/Shanghai");
		require ROOT_PATH.'phpmailer/class.phpmailer.php';
		require ROOT_PATH.'phpmailer/class.smtp.php';
		global $_CFG;
		$mail             = new PHPMailer(); //new一个PHPMailer对象出来
		//$body             = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
		$mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
		$mail->IsSMTP(); // 设定使用SMTP服务
		$mail->SMTPDebug  = 1;                     // 启用SMTP调试功能

		$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
		//$mail->SMTPSecure = "ssl";                 // 安全协议
		$mail->Host       = $_CFG['email'][2];      // SMTP 服务器
		$mail->Port       = $_CFG['email'][5];                   // SMTP服务器的端口号
		$mail->Username   = $_CFG['email'][3];  // SMTP服务器用户名
		$mail->Password   = $_CFG['email'][4];            // SMTP服务器密码
		$mail->SetFrom($_CFG['email'][1], '');//发件人名称
		$mail->AddReplyTo($_CFG['email'][1],'');//邮件回复
		$mail->Subject    = $subject;
		$mail->AltBody    = "text/html"; // optional, comment out and test
		$mail->MsgHTML($body);
		$address = $to;
		$mail->AddAddress($address, $toname);
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!恭喜，邮件发送成功！";
		}
	}
	
	public function mailtmp(){
		$mail=new model('mail_templates');
		global $smarty;
		$arr=$mail->select('id,skey,svalue');
		$tmparr=array(
				'set_reg'=>'注册会员',
				'set_order'=>'新增订单',
				'set_payment'=>'付款成功',
				'set_editpwd'=>'修改密码',);
		$result=array();
		foreach ($arr as $row){
			$result[]=array(
					'id'=>$row['id'],
					'skey'=>$tmparr[$row['skey']]
					);
		}
		$smarty->assign('list',$result);
		$smarty->display(DEFAUTL_PATH.'mail_tmp.htm');
	}
	
	public function mailview(){
		global $smarty;
		$mail=new model('mail_templates');
		$id=get('id');
		if ($id!==null){
			$field='id,skey,stitle,svalue';
			$data=$mail->where('id='.$id)->select($field);
			$data=$data[0];
			$smarty->assign($data);
			$smarty->assign('tab','?action=tools&operation=mailsave&id='.$id);
		}
		$smarty->display(DEFAUTL_PATH.'mail_tmp_info.htm');
	}
	
	public function mailsave(){
		$stitle=get('stitle');
		$svalue=get('svalue');
		$id=get('id');
		$data=array(
				'stitle'=>$stitle,
				'svalue'=>$svalue
				);
		$mail=new model('mail_templates');
		$mail->where('id='.$id)->data($data)->save();
	}
	
	//php操作xml

}