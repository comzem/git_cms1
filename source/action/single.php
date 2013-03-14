<?php
class single {
	protected $where='',$order='';
	function __construct(){
	}
	/**
	 * 添加
	 */
	public function save(){
		$data=array(
				"title"=>C::LeftStr(C::get('title'),100),
				"fid"=>C::isint(C::get('fid')),
				"content"=>C::htmlRepace(C::get('content')),
				"add_time"=>time(),
				"seotitle"=>C::LeftStr(C::get('seotitle'),200),
				"keywords"=>C::LeftStr(C::get('keywords'),200),
				"description"=>C::LeftStr(C::get('description'),300)
		);
		$single=new model('single');
		$id=C::get('id');
		if (!empty($id)){
			$result=$single->where('id='.$id)->data($data)->save();
		}else{
			$result=$single->data($data)->add();
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
		$single=new model('single');
		$single->where('id in ('.$idarr.')')->delete();
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	public function addclass(){
		$data=C::classify_exp();
		$stype=new model('single_classify');
		$stype->data($data)->addAll();
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	/**
	 *查找
	 */
	public function getclass(){
		$nav=C::getclass('single_classify');
		$smarty=new Smarty();
		$data=array(
				"tab"=>'?action=single&operation=addclass',
				'editurl'=>'?action=single&operation=classview&fid=',
				"nav"=>$nav,
				'action'=>'single',
				"table"=>'?action=single&operation=delclass');
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify.htm');
	}
	
	/**
	 * 删除分类
	 */
	public function classifydel(){
		$aclassify=new model('single_classify');
		$art=new model('single');
		$total=0;
		if (isset($_GET['id1'])){
			$id1=get('id1');
			$total=$aclassify->where('upid='.$id1)->getField('count(fid)');
			if ($total>0){
				msg('请先删除子类！', '-1');
				exit(0);
			}else{
				$art->where('fid='.$id1)->delete();
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
	 * 绑定分类到<select/>
	 * Enter description here ...
	 */
	public function selectf(){
		$nav=C::selectf('single_classify');
		return $nav;
	}
	/**
	 *查找
	 */
	public function getlist(){
		$single=new model('single');
		$smarty=new Smarty();
		$field='id,title,fid,content,sort,status,add_time,seotitle,keywords,description';
		$arr=$single->where($this->where)->order($this->order)->page($smarty, array('','','',''))->select($field);
		$data=array(
				'tab'=>'?action=single&operation=delete',
				'list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'single_list.htm');

	}


	/**
	 *添加视图
	 */
	public function view(){
		$smarty=new Smarty();
		$single=new model('single');
		$eid=C::get('id');
		$field='title,fid,content,sort,add_time,seotitle,keywords,description';
		$smarty->assign('fid_options',$this->selectf());
		if (!empty($eid)){
			$smarty->assign("tab","?action=single&operation=save&id=".$eid);
			$data=$single->where('id='.$eid)->select($field);
			$data=$data[0];
			$smarty->assign($data);
			$smarty->assign('content',C::noHtmlRepace($data['content']));
		}else{
			$smarty->assign("tab","?action=single&operation=save");
			$field_array=explode(',', $field);
			for ($i=0;$i<count($field_array);$i++){
				$smarty->assign($field_array[$i],'');
			}
		}
		$smarty->display(DEFAUTL_PATH.'single_info.htm');
	}
	
	public function getpage(){
		$stype=new model('single_classify');
		$arr=$stype->where('upid=0')->select('fid,title');
		$single=new model('single');
		$result=array();
		$sub=array();
		foreach ($arr as $row) {
			$arr1=$single->where('fid='.$row['fid'])->select('id,title');
			foreach ($arr1 as $row1) {
				$sub[]=array(
						'id'=>$row1['id'],
						'title'=>$row1['title']
				);
			}
			$result[]=array(
						'title'=>$row['title'],
						'sub'=>$sub
			);
		}
		return $result;
	}
	
	/**
	 * 显示分类详细内容
	 * Enter description here ...
	 */
	public function classview(){
		global $smarty;
		require FUNC_PATH.'article.fun.php';
		$eid=get('fid');
		$gdata=array(
				'tab'=>'?action=single&operation=setclass&id='.$eid,
				'upid_options'=>artclass('single_classify')
		);
		$smarty->assign($gdata);
		$field='fid,title,upid,sort,seotitle,keywords,description';
		$classify=new model('single_classify');
	
		$data=$classify->where('fid='.$eid)->select($field);
		$data=$data[0];
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify_info.htm');
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
		$data=array(
				'title'=>$title,
				'upid'=>$upid,
				'sort'=>$sort,
				'seotitle'=>$seotitle,
				'keywords'=>$keywords,
				'description'=>$description,
		);
		$gclassify=new model('single_classify');
		$gclassify->where('fid='.$id)->data($data)->save();
		echo "<script>parent.window.location.reload();</script>";
	}
	
}

?>