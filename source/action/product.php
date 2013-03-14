<?php
class product {
	protected $where='',$order='';
	private $yunfei=array("A"=>"卖家承担运费","B"=>"买家承担运费");
	private $type=array('1'=>'全新','2'=>'二手');
	private $cc=array('N'=>'无','Y'=>'有');
	private $ptype=array('1'=>'售前咨询','2'=>'顾客评价');
	private $_classify=array();
	function __construct(){
	}

	/**
	 * 添加第一张不能为空
	 */
	public function save(){
		$photo=C::get('photo');
		$data=array(
				"fid"=>C::isint(C::get('fid')),
				"title"=>C::LeftStr(C::get('title'),50),
				"price1"=>C::isfloat(C::get('price1')),
				"amount"=>C::isint(C::get('amount')),
				"point"=>C::isint(C::get('point')),
				"photo"=>str_replace('upload/', '', $photo[0]),
				"video"=>C::LeftStr(C::get('video'),50),
				"seotitle"=>C::LeftStr(C::get('seotitle'),200),
				"keywords"=>C::LeftStr(C::get('keywords'),200),
				"description"=>C::LeftStr(C::get('description'),300),
				"yuanfei"=>C::LeftStr(C::get('yuanfei'),1),
				"pingyou"=>C::isint(C::get('pingyou')),
				"kuaidi"=>C::isint(C::get('kuaidi')),
				"ems"=>C::isint(C::get('ems')),
				"fapiao"=>C::LeftStr(C::get('fapiao'),1),
				"baoxiu"=>C::LeftStr(C::get('baoxiu'),1),
				"tuihuo"=>C::LeftStr(C::get('tuihuo'),1),
				"city1"=>C::LeftStr(C::get('city1'),5),
				"city2"=>C::LeftStr(C::get('city2'),10),
				"type"=>C::get('type'),
				"bianma"=>C::LeftStr(C::get('bianma'),20),
				"dazhe"=>C::get('dazhe'),
				"add_time"=>time(),
				"ip"=>C::ip()
		);

		$goods=new model('goods');
		$descrip=new model('goods_descrip');
		$attach=new model('goods_attachment');
		$property=new model('goods_property');
		$img_data=array();
		$id=C::get('id');
		if (!empty($id)){
			$result=$goods->data($data)->where('pid='.$id)->save();
			
			//更新描述
			$des_data=array('pid'=>$id,'content'=>C::noHtmlRepace(C::get('content')));
			$descrip->where('pid='.$id)->data($des_data)->save();
			//更新图片（图片名称不变，异步删除，不同则增加）

			//更新自定义属性
			$e_skey=get('e_skey');
			$e_svalue=get('e_svalue');
			for($i=0;$i<count($e_skey);$i++){
				$e_data=array(
						'svalue'=>$e_svalue[$i],
				);
				$property->where("pid=$id and locate(skey,'$e_skey[$i]')")->data($e_data)->save();
			}
			
			$skey=C::get('skey');
			$svalue=C::get('svalue');
			for($i=0;$i<count($skey);$i++){
				if (!empty($skey[$i]) && !empty($svalue[$i])){
				$pro_data=array(
							'pid'=>$id,
							'skey'=>$skey[$i],
							'svalue'=>$svalue[$i],
						);
				$property->data($pro_data)->add();				
				}
			}				
		}else{
			$pid=$goods->data($data)->add();
			
			//添加描述
			$des_data=array('pid'=>$pid,'content'=>C::noHtmlRepace(C::get('content')));
			$descrip->data($des_data)->add();
			
			//添加图片
			for ($i=0;$i<count($photo);$i++){
				if (!empty($photo[$i]))
				$img_data[]=array('pid'=>$pid,'attachment'=>str_replace('upload/', '', $photo[$i]));
			}
			$attach->data($img_data)->addAll();
			
			//添加描述图片
			if (isset($_SESSION['editor_img']['goods'])){
				$editor_attch=$_SESSION['editor_img']['goods'];
				$ed=new model('editor_attachment');
				$ed_data=array();
				for ($j=0;$j<count($editor_attch);$j++){
					if (!empty($editor_attch[$i]))
						$ed_data[]=array('id'=>$pid,'attachment'=>str_replace('../upload/', '', $editor_attch[$i]),'part'=>'goods');
				}
				$ed->data($ed_data)->addAll();
				$_SESSION['editor_img']['goods']=array();
				unset($_SESSION['editor_img']['goods']);
			}
			//添加自定义静态属性

			//添加自定义动态属性
			$skey=C::get('skey');
			$svalue=C::get('svalue');
			$proa_data=array();
			for($i=0;$i<count($skey);$i++){
				if (!empty($skey[$i]) && !empty($svalue[$i])){
					$proa_data[]=array(
							'pid'=>$pid,
							'skey'=>$skey[$i],
							'svalue'=>$svalue[$i],
					);					
				}
			}
			$property->data($proa_data)->addAll();
			
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	/**
	 *批量删除
	 */
	public function delete(){
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		$goods=new model('goods');
		$goods->where('pid in ('.$idarr.')')->delete();
		//删除图片
		$attach=new model('goods_attachment');
		//删除实际图片
		$attach_img=$attach->where('pid in ('.$idarr.')')->select('attachment');
		foreach ($attach_img as $img){
			@unlink(UPLOAD_PATH.$img['attachment']);
		}
		$attach->where('pid in ('.$idarr.')')->delete();
		//删除描述
		$descrip=new model('goods_descrip');
		$descrip->where('pid in ('.$idarr.')')->delete();
		//删除自定义静态属性

		//删除自定义动态属性
		$property=new model('goods_property');
		$property->where('pid in ('.$idarr.')')->delete();
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	public function addclass(){
		$data=C::classify_exp();
		$gtype=new model('goods_classify');
		if (is_array($data)){			
			$result=$gtype->data($data)->addAll();			
		}
		$edit_fid=get('edit_fid');
		$edit_sort=get('edit_sort');
		$edit_title=get('edit_title');
		if (count($edit_fid)>0 && count($edit_sort)>0 && count($edit_title)>0){
			for ($i=0;$i<count($edit_fid);$i++){
				$edata=array(
						'sort'=>$edit_sort[$i],
						'title'=>$edit_title[$i]
						);
				$gtype->where('fid='.$edit_fid[$i])->data($edata)->save();
			}
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}



	/**
	 *查找
	 */
	public function getclass(){
		$nav=C::getclass('goods_classify');
		$smarty=new Smarty();
		$data=array(
				"tab"=>'?action=product&operation=addclass',
				"nav"=>$nav,
				'action'=>'product',
				"table"=>'?action=product&operation=delclass',
				'ajaxurl'=>'?action=product&operation=classasy',
				'editurl'=>'?action=product&operation=classview&fid=');
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify.htm');
	}
	
	public function classview(){
		global $smarty;
		require FUNC_PATH.'goods.fun.php';
		$eid=get('fid');
		$gdata=array(
				'tab'=>'?action=product&operation=setclass&id='.$eid,
				'upid_options'=>goodsclass(),
				'display_options'=>array('Y'=>'是','N'=>'否')
		);
		$smarty->assign($gdata);
		$field='fid,title,upid,sort,seotitle,keywords,description,display';
		$classify=new model('goods_classify');
		
		$data=$classify->where('fid='.$eid)->select($field);
		$data=$data[0];
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify_goods.htm');
	}
	
	/**
	 * 设置分类详细内容
	 * Enter description here ...
	 */
	public function setclass(){
		$id=get('id');
		$title=get('title');
		if ($title===null){
			msg('请填写完整', '-1');
			exit(0);
		}
		$upid=get('upid');
		$sort=get('sort');
		$seotitle=get('seotitle');
		$keywords=get('keywords');
		$description=get('description');
		$display=get('display');
		$data=array(
				'title'=>$title,
				'upid'=>$upid,
				'sort'=>$sort,
				'seotitle'=>$seotitle,
				'keywords'=>$keywords,
				'description'=>$description,
				'display'=>$display
				);
		$gclassify=new model('goods_classify');
		$gclassify->where('fid='.$id)->data($data)->save();
		echo "<script>parent.window.location.reload();</script>";
	}
	
	/**
	 * 删除分类
	 */
	public function classifydel(){
		$aclassify=new model('goods_classify');
		$art=new model('goods');
		$total=0;
		if (isset($_GET['id1'])){
			$id1=get('id1');
			$total=$aclassify->where('upid='.$id1)->getField('count(fid)');
			if ($total>0){
				msg('请先删除子类！', '-1');
				exit(0);
			}else{
				//删除产品
				$art->where('fid='.$id1)->delete();
				//删除描述
				//删除图片，编辑器图片
				
				$aclassify->where('fid='.$id1)->delete();
			}
		}
		if (isset($_GET['id2'])){
			$id2=get('id2');
			$total=$aclassify->where('upid='.$id2)->getField('count(fid)');
			if ($total>0){
				msg('请先删除子类！', '-1');
				exit(0);
			}else{
				$art->where('fid='.$id2)->delete();
				$aclassify->where('fid='.$id2)->delete();
			}
		}
		if (isset($_GET['id3'])){
			$id3=get('id3');
			$art->where('fid='.$id3)->delete();
			$aclassify->where('fid='.$id3)->delete();
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	

	/**
	 * 绑定商品分类到<select/>
	 * Enter description here ...
	 */
	public function selectf(){
		$nav=C::selectf('goods_classify');
		return $nav;
	}

	/**
	 * 查找前几条记录
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 */
	public function selectTop($where,$order,$limit){
		$goods=new model('goods');
		$field='fid,title,price1,amount,point,photo,video,seotitle,keywords,description,
		yuanfei,pingyou,kuaidi,ems,fapiao,baoxiu,tuihuo,city1,city2,type,bianma,dazhe,hits,add_time,ip';
		$arr=$goods->where($where)->order($order)->limit($limit)->select($field);
		return $arr;
	}

	/**
	 *查找
	 */
	public function getlist(){
		$goods=new model('goods');
		$smarty=new Smarty();
		$url='';
		$fid=C::get('fid');
		$title=C::get('title');
		$status=C::get('status');
		$this->where='1=1';
		if ($fid!=null){
			$this->where.=" and fid=$fid";
		}
		if ($title!=null){
			$this->where.=" and title like '%".$title."%'";
		}
		if ($status!=null){
			$this->where.=" and status=".$status;
		}
		$this->order='add_time desc,pid desc';
		$field='pid,fid,title,price1,amount,photo,video,fapiao,baoxiu,tuihuo,city1,city2,type,bianma,dazhe,add_time,status,istop';
		$arr=$goods->where($this->where)->order($this->order)->page($smarty, array('fid','','',$url))->select($field);
		$class_array=array(''=>'所有分类');
		$class_array+=C::selectf('goods_classify');
		$data=array(
				'tab'=>'?action=product&operation=delete',
				'list'=>$arr,
				'fid_options'=>$class_array,
				'fid'=>'',
				'footmsg'=>C::execute_time());
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'product_list.htm');
	}

	/**
	 *添加视图
	 */
	public function view(){
		$goods=new model('goods');
		$descrip=new model('goods_descrip');
		$attach=new model('goods_attachment');
		$property=new model('goods_property');
		include ACTION_PATH.'tools.php';
		$tools=new tools();
		$smarty=new Smarty();
		$id=C::get('id');
		$t_data=array(
				'fid_options'=>$this->selectf(),
				'type_options'=>$this->type,
				'city1_options'=>$tools->area(),
				'city2_options'=>'请选择...',
				'yuanfei_options'=>$this->yunfei,
				'fapiao_options'=>$this->cc,
				'baoxiu_options'=>$this->cc,
				'tuihuo_options'=>$this->cc,
				'dazhe_options'=>array('0'=>'不参与会员打折','1'=>'参与会员打折'));
		$field='fid,title,status,price1,amount,point,photo,video,seotitle,keywords,description,yuanfei,pingyou,kuaidi,ems,fapiao,baoxiu,tuihuo,city1,city2,type,bianma,dazhe';
		if (!empty($id)){
			$smarty->assign("tab","?action=product&operation=save&id=".$id);
			//产品信息
			$data=$goods->where('pid='.$id)->select($field);
			$data=$data[0];
			//产品属性
			$p_data=$property->where('pid='.$id)->select('skey,svalue');
			//图片
			$img_data=$attach->where('pid='.$id)->select('attachment');
			for($i=0;$i<5;$i++){
				if (isset($img_data[$i]['attachment'])){
					$smarty->assign("photo".$i,'upload/'.$img_data[$i]['attachment']);
					$smarty->assign("img_photo".$i,'upload/'.$img_data[$i]['attachment']);
				}else{
					$smarty->assign("photo".$i,'');
					$smarty->assign("img_photo".$i,'images/upload.gif');
				}
			}
			//描述
			$des_data=$descrip->where('pid='.$id)->getField('content');
			$smarty->assign('list',$p_data);
			$smarty->assign('content',$des_data);
		}else{
			$smarty->assign("tab","?action=product&operation=save");
			$field_array=explode(',', $field);
			for ($i=0;$i<count($field_array);$i++){
				$smarty->assign($field_array[$i],'');
			}
			$data=array(
					'type'=>'1',
					'yuanfei'=>'B',
					'fapiao'=>'N',
					'baoxiu'=>'N',
					'tuihuo'=>'N',
					'dazhe'=>'0',
					'content'=>'');
			for($i=0;$i<5;$i++){
				$smarty->assign("photo".$i,'');
				$smarty->assign("img_photo".$i,'images/upload.gif');
			}
			$smarty->assign('list','');
		}		
		$smarty->assign($data);
		$smarty->assign($t_data);
		$smarty->display(DEFAUTL_PATH.'product_info.htm');
	}


	/**
	 *更新某值
	 */
	public function asy(){
		$goods=new model('goods');
		$id=C::get('id');
		$fd=C::get('fd');//字段
		$val=C::get('val');//值
		$data=array(
				$fd=>$val,
				'add_time'=>time()
				);
		echo $goods->data($data)->where('pid='.$id)->save();
	}
	
	//更改价格
	public function setnc(){
		$fid=C::get('fid');
		$p=C::get('p');
		$s=C::get('s');
		$goods=new model('goods');
		$where='1=1';
		if (!empty($fid))
			$where='fid='.$fid;
		if ($s=='add'){
			$goods->where($where)->setInc('price1', $p);
		}
		elseif ($s=='cut'){
			$goods->where($where)->setDec('price1', $p);
		}		
		C::msg('', '?action=product&operation=getlist');
	}

	/**
	 *更新某值
	 */
	public function classasy(){
		$goods=new model('goods_classify');
		$id=C::get('id');
		$fd=C::get('fd');//字段
		$val=C::get('val');//值
		$data=array($fd=>$val);
		$goods->data($data)->where('fid='.$id)->save();
	}
	
	/**
	 * 产品评论咨询
	 */
	public function comments(){
		if (isset($_SESSION['auth_user'])){
			list($uid,$username,$gid)=explode('\t', C::_authcode($_SESSION['auth_user'],'DECODE'));
		}else{
			$uid=0;
		}
		$data=array(
				'pid'=>C::get('product_id'),
				'content'=>C::get('content'),
				'uid'=>$uid,
				'add_time'=>time(),
				'ip'=>C::ip(),
				'fid'=>C::get('fid'),
			);
		$comments=new model('goods_comments');
		$comments->data($data)->add();
	}
	
	//返回评论
	public function get_comments(){
		$comments=new model('goods_comments');
		$fid=get('fid');
		$pid=get('pid');
		$field='cid,pid,content,add_time,username,cid,closed';
		global $smarty;
		$where="fid=$fid";
		if ($fid!=null && $pid!=null){
			$where="fid=$fid and pid=$pid";
		}
		$url='?action=product&operation=get_comments&fid='.$fid.'&pid='.$pid.'&p=';
		$arr=$comments->where($where)->page($smarty, array('cid','10','',$url))->select($field);
		$data=array(
				'pl'=>$arr,
				'tab1'=>'?action=product&operation=ch_comments&t=del',
				'tab2'=>'?action=product&operation=ch_comments&t=verify',
				'tab3'=>'?action=product&operation=ch_comments&t=lock',
				);		
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'product_comments.htm');
	}
	
	public function upst_comments(){
		$goods=new model('goods_comments');
		$id=C::get('id');
		$fd=C::get('fd');//字段
		$val=C::get('val');//值
		$data=array(
				$fd=>$val,
		);
		echo $goods->data($data)->where('cid='.$id)->save();
	}

	//删除评论,审核,锁定
	public function ch_comments(){
		$id=get('check_id');
		if ($id!==null){
			$id=implode(',', $id);
			$goods=new model('goods_comments');
			$t=get('t');
			switch ($t){
				case 'del':
					$goods->where("cid in ($id)")->delete();
					msg('删除成功！', '-1');
					break;
				case 'verify':
					$goods->where("cid in ($id)")->setField('closed=1');
					msg('审核成功！', '-1');
					break;
				case 'lock':
					$goods->where("cid in ($id)")->setField('closed=0');
					msg('锁定成功！', '-1');
					break;
			}			
		}else{
			msg('', '-1');
		}
	}

}

?>