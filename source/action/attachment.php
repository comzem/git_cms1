<?php
class attachment{
	protected $where='',$order='';
	function __construct(){
	}

	/**
	 * 添加
	 */
	public function save(){
		$picture='';
		$attachment=get('attachment');
		$details=get('details');
		if (count($attachment)>0 || count(get('e_attachment'))>0){
			$e_attachment=get('e_attachment');			
			$picture=($attachment===null)?$e_attachment[0]:$attachment[0];
			$picture=str_replace(UPLOAD_PATH, '', $picture);
		}else{
			msg('请填上传图片', '-1');
			exit(0);
		}
		$data=array(
				"fid"=>get('fid'),
				"title"=>C::LeftStr(get('title'),50),
				"attachment"=>$picture,
				"uid"=>0,
				"add_time"=>time(),
		);
		
		$attach=new model('attachment');
		$image=new model('attachment_image');
		$idata=array();
		if (isset($_GET['id'])){
			$aid=get('id','G');
			$eid=get('eid','P');
			$attach->data($data)->where('aid='.$aid)->save();
			//修改图片
			$e_attachment=get('e_attachment');
			$e_details=get('e_details');
			for($i=0;$i<count($e_attachment);$i++){
				$edata=array(
						'attachment'=>str_replace(UPLOAD_PATH, '', $e_attachment[$i]),
						'details'=>$e_details[$i]
				);
				$image->where('id='.$eid[$i])->data($edata)->save();
			}
			//增加图片、描述
			for($i=0;$i<count($attachment);$i++){
				$idata[]=array(
						'aid'=>$aid,
						'attachment'=>str_replace(UPLOAD_PATH, '', $attachment[$i]),
						'details'=>$details[$i]
				);
			}
			$image->data($idata)->addAll();
		}else{
			$resultid=$attach->data($data)->add();
			//添加多图到另一张表
			for($i=0;$i<count($attachment);$i++){
				$idata[]=array(
						'aid'=>$resultid,
						'attachment'=>str_replace(UPLOAD_PATH, '', $attachment[$i]),
						'details'=>$details[$i]
					);		
			}
			$image->data($idata)->addAll();
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	public function addclass() {
		$data=C::classify_exp();
		if (is_array($data)){
			$gtype=new model('attachment_classify');
			$result=$gtype->data($data)->addAll();
			C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
		}else{
			C::msg($data, '-1');
		}
	}

	/**
	 *查找
	 */
	public function getclass(){
		$nav=C::getclass('attachment_classify');
		$smarty=new Smarty();
		$data=array(
				"tab"=>'?action=attachment&operation=addclass',
				"nav"=>$nav,
				"table"=>'?action=attachment&operation=delclass',
				'ajaxurl'=>'?action=attachment&operation=classasy');
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify.htm');
	}

	/**
	 *批量删除
	 */
	public function delete(){
		$idarr=C::get('check_id');
		if (!isset($idarr)){
			C::msg('请选择要删除的图片', '-1');
			exit(0);
		}
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		$attach=new model('attachment');
		$attach->where('aid in ('.$idarr.')')->delete();
		//删除实际图片
		$image=new model('attachment_image');
		$imagelist=$image->where('aid in ('.$idarr.')')->select('attachment');
		for ($i=0;$i<count($imagelist);$i++){
			$filename=UPLOAD_PATH.$imagelist[$i]['attachment'];
			if (file_exists($filename)){
				unlink($filename);
			}
		}
		$image->where('aid in ('.$idarr.')')->delete();
		C::msg('', '/source/redirect.php?msg=删除成功&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	public function deleteimg(){
		$id=get('id');
		$filename=UPLOAD_PATH.get('img');
		$image=new model('attachment_image');
		if (file_exists($filename)){
			unlink($filename);
		}
		$image->where('id='.$id)->delete();
		C::msg('', '-1');
	}


	/**
	 *查找
	 */
	public function getlist(){
		$attach=new model('attachment');
		$smarty=new Smarty();
		$field='aid,fid,title,attachment,add_time';
		$arr=$attach->where($this->where)->order($this->order)->page($smarty)->select($field);		
		$data=array(
				'tab'=>'?action=attachment&operation=delete',
				'list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'attach_list.htm');
	}
	
	public function view(){
		global $smarty;
		$attach=new model('attachment');
		$image=new model('attachment_image');
		$eid=get('id');
		$smarty->assign('fid_options',C::selectf('attachment_classify'));
		if (!empty($eid)){
			$smarty->assign('tab','?action=attachment&operation=save&id='.$eid);
			$field='fid,title';
			$data=$attach->where('aid='.$eid)->select($field);
			$smarty->assign($data[0]);
			$imagedata=$image->where('aid='.$eid)->select('aid,attachment,details,id');
			$smarty->assign('list',$imagedata);
		}else{
			$data=array(
					'tab'=>'?action=attachment&operation=save',
					'fid'=>'',
					'title'=>'',
					'list'=>'');
			$smarty->assign($data);
		}		
		$smarty->display(DEFAUTL_PATH.'attach_add.htm');
	}
	
	public function space(){
		$t=get('t');
		global $smarty;
		$result=array();
		$url='?action=attachment&operation=space&t='.$t.'&p=';
		$tab='';
		switch ($t){
			case 'goods':
				$attach=new model('goods_attachment');
				$arr=$attach->page($smarty,array('pid','40','',$url))->select('pid,attachment');
				foreach ($arr as $row){
					$result[]=array(
							'id'=>$row['pid'],
							'attachment'=>$row['attachment']
							);
				}
				$tab='?action=attachment&operation=del_spaceimg&t=goods';
				break;
			case 'editor':
				$attach=new model('editor_attachment');
				$arr=$attach->page($smarty,array('id','40','',$url))->select('id,attachment');
				foreach ($arr as $row){
					$result[]=array(
							'id'=>$row['id'],
							'attachment'=>$row['attachment']
					);
				}
				$tab='?action=attachment&operation=del_spaceimg&t=editor';
				break;
		}
		$data=array(
				'list'=>$result,
				'tab'=>$tab
				);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'attach_space.htm');
	}
	

	//删除图片
	public function del_spaceimg(){
		$chkid=get('check_id');
		$gattach=new model('goods_attachment');
		$eattach=new model('editor_attachment');
		$t=get('t');
		for($i=0;$i<count($chkid);$i++){
			$pic=explode('|', $chkid[1]);
			if (file_exists(ROOT_PATH.$pic[1])){
				unlink(ROOT_PATH.$pic[1]);
			}
			if ($t=='goods'){
				$gattach->where("pid=$pic[0] and attachment='$pic[1]'")->delete();
			}else if ($t=='editor'){
				$eattach->where("id=$pic[0] and attachment='$pic[1]'")->delete();
			}
		}	
		C::msg('', '/source/redirect.php?msg=删除成功&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	

}

?>