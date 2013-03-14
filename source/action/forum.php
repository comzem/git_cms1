<?php
class forum{
	
	public function save(){
		$data=array(
				'subject'=>get('subject')
				);
	}
	/**
	 * 讨论区分类
	 */
	public function addclass(){
		$data=C::classify_exp();
		if (is_array($data)){
			$arctype=new model('forum_classify');
			$result=$arctype->data($data)->addAll();
			C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
		}else{
			C::msg($data, '-1');
		}
	}
	
	public function getclass(){
		$nav=C::getclass('forum_classify');
		$smarty=new Smarty();
		$data=array(
				"tab"=>'?action=forum&operation=addclass',
				"nav"=>$nav,
				'ajaxurl'=>'?action=forum&operation=classasy');
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify.htm');
	}
	
	/**
	 *更新某值
	 */
	public function classasy(){
		$arc=new model('forum_classify');
		$id=C::get('id');
		$fd=C::get('fd');//字段
		$val=C::get('val');//值
		$data=array($fd=>$val);
		$arc->data($data)->where('fid='.$id)->save();
	}
	
	/**
	 * 论坛主题
	 */
	public function thread(){
		$th=new model('forum');
		$smarty=new Smarty();
		$this->order='dateline desc,tid desc';
		$field='tid,fid,subject,author,authorid,dateline,lastpost,lastposter,views,replies,highlight,digest,attachment,closed';
		$arr=$th->order($this->order)->page($smarty, array('','','',''))->select($field);
		$data=array('list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'forum_thread.htm');
	}
	
	/**
	 *批量删除
	 */
	public function delete(){
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		//删除主题
		$th=new model('forum');
		$th->where('tid in ('.$idarr.')')->delete();
		//删除回复
		$rep=new model('forum_reply');
		$rep->where('tid in ('.$idarr.')')->delete();
		//删除附件
		$att=new model('forum_attachment');
		//删除实际图片
		$attlist=$att->where('tid in ('.$idarr.')')->select('attachment');
		for ($i=0;$i<count($attlist);$i++){
			$file_path='upload/'.$attlist[$i]['attachment'];
			if (file_exists($file_path)){
				unlink($file_path);
			}
		}
		$att->where('tid in ('.$idarr.')')->delete();
	}
}