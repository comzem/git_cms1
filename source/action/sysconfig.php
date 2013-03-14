<?php
class sysconfig {
	private $radio=array("1"=>"是","0"=>"否");
	private $imgwater_set=array("0"=>"不启用水印功能","1"=>"#1","2"=>"#2","3"=>"#3","4"=>"#4","5"=>"#5","6"=>"#6","7"=>"#7","8"=>"#8","9"=>"#9");
	private $imgwater_type=array("1"=>"图片水印","2"=>"文字水印");
	private $pay=array("1"=>"是","0"=>"否");
	private $yz=array("0"=>"无","1"=>"email验证",'2'=>'手工验证');
	private $email_type=array('sendmail'=>'通过 PHP 函数的 sendmail 发送(推荐此方式)');
	private $forum_type=array('1'=>'普通留言','2'=>'论坛式留言');
	private $attch=array('month'=>'按月','day'=>'按日');
	private $conver=array('cookie'=>'COOKIE方案(存放于客户端)','session'=>'SESSION方案(存放于服务端)','sessionsql'=>'SESSION方案(存放于数据库)');
	private $lang=array('simple'=>'简体中文');
	private $disp_0=array('add_time'=>'上架时间','price1'=>'价格','sales'=>'销量','score'=>'评分');
	private $disp_1=array('desc'=>'降序','asc'=>'升序');
	private $disp_2=array('list'=>'普通列表','win'=>'橱窗形式');
	function __construct(){
	}

	/**
	 * 显示
	 */
	public function view(){
		$type=C::get('type');
		$smarty=new Smarty();
		$set=new model('setting');
		$_list=$set->where("skey='$type'")->getField('svalue');
		$_arr=explode('	', $_list);
		switch ($type){
			case "website":
				$data=array(
						's0'=>$_arr[0],
						's1'=>$_arr[1],
						's2'=>$_arr[2],
						's3'=>$_arr[3],
						's4'=>$_arr[4],
						's5'=>$_arr[5],
						's6'=>$_arr[6],
						's7'=>$_arr[7],
						's8'=>$_arr[8]
				);
				break;
			case "register":
				$data=array('r0_options'=>$this->pay,'r4_options'=>$this->yz,'r6_options'=>$this->pay,'r8_options'=>$this->pay,
				'r0'=>$_arr[0],'r1'=>$_arr[1],'r2'=>$_arr[2],'r3'=>$_arr[3],'r4'=>$_arr[4],'r5'=>$_arr[5],'r6'=>$_arr[6],'r7'=>$_arr[7],'r8'=>$_arr[8],'r9'=>$_arr[9]);
				break;
			case "seo":
				$data=array('s0'=>$_arr[0],'s1'=>$_arr[1],'s2'=>$_arr[2],'s3'=>$_arr[3],'s4'=>$_arr[4],'s5'=>$_arr[5],'s6'=>$_arr[6],'s7'=>$_arr[7],
				's8'=>$_arr[8],'s9'=>$_arr[9],'s10'=>$_arr[10],'s11'=>$_arr[11],'s12'=>$_arr[12],'s13'=>$_arr[13],'s14'=>$_arr[14],'s15'=>$_arr[15],'s16'=>$_arr[16],
				's17'=>$_arr[17],'s18'=>$_arr[18],'s19'=>$_arr[19],'s20'=>$_arr[20],'s21'=>$_arr[21],'s22'=>$_arr[22],'s23'=>$_arr[23]);
				break;
			case "interactive":
				$data=array('i0_options'=>$this->forum_type,'i0'=>$_arr[0],'i1'=>$_arr[1],
							'i2_options'=>array("0"=>"是","1"=>"否"),'i2'=>$_arr[2],
							'i3_options'=>$this->pay,'i3'=>$_arr[3],
							'i4'=>$_arr[4],'i5_options'=>$this->pay,'i5'=>$_arr[5]);
				break;
			case "attachment":
				$data=array('a0'=>$_arr[0],'a1'=>$_arr[1],'a2'=>$_arr[2],'a3'=>$_arr[3],'a4_options'=>$this->attch,'a4'=>$_arr[4]);
				break;
			case "water":
				$data=array('w0_options'=>$this->imgwater_set,'w0'=>$_arr[0],'w1'=>$_arr[1],'w2'=>$_arr[2],'w3_options'=>$this->imgwater_type,'w3'=>$_arr[3],'w4'=>$_arr[4]);
				break;
			case "email":
				$data=array('e0_options'=>$this->email_type,'e0'=>$_arr[0],'e1'=>$_arr[1],'e2'=>$_arr[2],'e3'=>$_arr[3],
							'e4'=>$_arr[4],'e5'=>$_arr[5],'e6'=>$_arr[6]);
				break;
			case "display":
				$data=array(
						'd0_options'=>$this->disp_0,
						'd0'=>$_arr[0],
						'd1_options'=>$this->disp_1,
						'd1'=>$_arr[1],
						'd2_options'=>$this->disp_2,
						'd2'=>$_arr[2],
						'd3'=>$_arr[3],
						'd4_options'=>array('1'=>'显示','0'=>'不显示'),
						'd4'=>$_arr[4],
						'd5'=>$_arr[5],
						'd6'=>$_arr[6],);
				break;
			case "foot":
				$data=array('f0'=>$_list);
				break;
			case "system":
				$data=array('s0_options'=>$this->conver,'s0'=>$_arr[0],
							's1_options'=>$this->lang,'s1'=>$_arr[1],
							's2_options'=>$this->pay,'s2'=>$_arr[2],
							's3_options'=>$this->pay,'s3'=>$_arr[3],'s4'=>$_arr[4],
							's5_options'=>array('false'=>'正常模式','true'=>'调式模式'),'s5'=>$_arr[5]);
				break;
			case "alipay":
				$data=array(
						'a0'=>$_arr[0],
						'a1'=>$_arr[1],
						'a1_options'=>$this->pay,
						'a2'=>$_arr[2],
						'a3'=>$_arr[3],
				);
				break;
			case "tenpay":
				$data=array(
						'a0'=>$_arr[0],
						'a1'=>$_arr[1],
						'a2'=>$_arr[2],
						'a3'=>$_arr[3],
				);
				break;
		}
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'set_'.$type.'.htm');
	}

	/**
	 * 保存
	 */
	public function save(){
		$post=$_POST;
		$type=C::get('type');
		$set=new model('setting');
		$svalue='';
		foreach ($post as $key=>$value) {
			$svalue.='\t'.$value;
		}
		$data=array('svalue'=>substr($svalue, 2));
		$set->where("skey='$type'")->data($data)->save();
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	/**
	 * 显示系统信息
	 */
	public function sinfo(){
		$db=new model('');
		$smarty=new Smarty();
		$mysql=$db->query('SELECT VERSION()');
		$data=array(
				'os'=>PHP_OS,
				'php'=>PHP_VERSION,
				'service'=>$_SERVER['SERVER_SOFTWARE'],
				'mysql'=>$mysql[0]['VERSION()'],
				'upsize'=>ini_get('upload_max_filesize'),
				'sqlsize'=>''
				);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'sinfo.htm');
	}
	
	/**
	 * 风格管理
	 */
	public function styles(){
		$smarty=new Smarty();
		$smarty->display(DEFAUTL_PATH.'styles.htm');
	}
	
	/**
	 * 模板管理
	 */
	public function templates(){
		$tmp=new model('template');
		$smarty=new Smarty();
		$url='';
		$field='templateid,name,directory,copyright,`default`';
		$result=$tmp->page($smarty, array('templateid','','',$url))->select($field);
		$data=array(
				'list'=>$result,
				'tab'=>'?action=sysconfig&operation=savetmp'
				);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'templates.htm');
	}
	
	public function savetmp(){
		$data=array(
				'name'=>C::get('name'),
				'directory'=>C::get('directory'),
				'copyright'=>C::get('copyright')
		);
		$tmp=new model('template');
		$tmp->data($data)->add();
		C::msg('', $_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * 卸载模板
	 */
	public function tmpdel(){
		$tmp=new model('template');
		//删除模板文件
		
		//删除数据库信息
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		$result=$tmp->where('templateid in ('.$idarr.')')->delete();		
		C::msg('', $_SERVER['HTTP_REFERER']);
	}
}

?>