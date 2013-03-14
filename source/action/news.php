<?php
class news {
	protected $where='',$order='';
	private $property=array('h'=>'头条','c'=>'推荐','f'=>'幻灯');
	private $pr=array('Y'=>'允许评论','N'=>'不允许评论');
	function __construct(){
	}

	/**
	 * 添加
	 */
	public function save(){
		if (isset($_SESSION['editor_img']['atricle']) && !empty($_SESSION['editor_img']['atricle'])){
			$img=$_SESSION['editor_img']['atricle'];
		}
		$data=array(
				 "title"=>C::LeftStr(C::get('title'),100),
				 "fid"=>C::isint(C::get('fid')),
				 "uid"=>0,
				 "photo"=>$img[0],//首张图片
				 "source"=>C::LeftStr(C::get('source'),60),
				 "add_time"=>time(),
				 "highlight"=>C::get('highlight'),
				 "property"=>C::getCheckbox(C::get('property')),
				 "seotitle"=>C::LeftStr(C::get('seotitle'),200),
				 "keywords"=>C::LeftStr(C::get('keywords'),200),
				 "description"=>C::LeftStr(C::get('description'),300),
				 "links"=>C::LeftStr(C::get('links'),200),
				 "intro"=>C::LeftStr(C::get('intro'),255),
				 "discuss"=>C::get('discuss'),
				 "readperm"=>C::get('readperm'),//阅读权限
		 		 "label"=>C::get('label')
		);
		$content=C::htmlRepace(C::get('content'));
		$arc=new model('article');
		$des=new model('article_descrip');
		$attch=new model('editor_attachment');
		if (isset($_GET['id'])){
			$id=C::get('id');
			//更改正文
			$arc->data($data)->where('aid='.$id)->save();
			//更改描述
			$des_data=array('aid'=>$id,'content'=>$content);
			$des->where('aid='.$id)->data($des_data)->save();
		}else{
			//添加正文
			$aid=$arc->data($data)->add();
			//添加描述
			$des_data=array('aid'=>$aid,'content'=>$content);
			$des->data($des_data)->add();
			//添加描述图片 新闻第一张为索引图
			$attch_data=array();
			if (isset($_SESSION['editor_img']['atricle']) && !empty($_SESSION['editor_img']['atricle'])){				
				for ($i=0;$i<count($img);$i++){
					$attch_data[]=array('id'=>$aid,'attachment'=>$img[$i],'part'=>'atricle');
				}
				$attch->data($attch_data)->addAll();
			}
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	public function addclass(){
		//添加
		$data=C::classify_exp();
		$arctype=new model('article_classify');
		if (is_array($data) && !empty($data)){			
			$result=$arctype->data($data)->addAll();
		}
		//修改
		$edit_fid=get('edit_fid');
		$edit_sort=get('edit_sort');
		$edit_title=get('edit_title');
		if (count($edit_fid)>0 && count($edit_sort)>0 && count($edit_title)>0){
			for ($i=0;$i<count($edit_fid);$i++){
				$edata=array(
						'sort'=>$edit_sort[$i],
						'title'=>$edit_title[$i]
				);
				$arctype->where('fid='.$edit_fid[$i])->data($edata)->save();
			}
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
		
	}

	/**
	 *查找
	 */
	public function getclass(){
		$nav=C::getclass('article_classify');
		$smarty=new Smarty();
		$data=array(
				"tab"=>'?action=news&operation=addclass',
				'editurl'=>'?action=news&operation=classview&fid=',
				"nav"=>$nav,
				'action'=>'news',
				'ajaxurl'=>'?action=product&operation=classasy');
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'classify.htm');
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
				'tab'=>'?action=news&operation=setclass&id='.$eid,
				'upid_options'=>artclass()
		);
		$smarty->assign($gdata);
		$field='fid,title,upid,sort,seotitle,keywords,description';
		$classify=new model('article_classify');
		
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
		$gclassify=new model('article_classify');
		$gclassify->where('fid='.$id)->data($data)->save();
		echo "<script>parent.window.location.reload();</script>";
	}
	
	/**
	 * 删除分类
	 */
	public function classifydel(){
		$aclassify=new model('article_classify');
		$art=new model('article');
		$total=0;
		if (isset($_GET['id1'])){
			$id1=get('id1');
			$total=$aclassify->where('upid='.$id1)->getField('count(fid)');
			if ($total>0){
				msg('请先删除子类！', '-1');
				exit(0);
			}else{
				//删除内容
				$art->where('fid='.$id1)->delete();
				//删除描述
				//删除编辑器图片
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
		$nav=C::selectf('article_classify');
		return $nav;
	}
	/**
	 *批量删除
	 */
	public function delete(){
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		//删除新闻
		$arc=new model('article');
		$arc->where('aid in ('.$idarr.')')->delete();
		//删除评
		$comm=new model('article_comments');
		$comm->where('aid in ('.$idarr.')')->delete();
		C::msg('', '/source/redirect.php?msg=操作成功&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	/**
	 *分页查找
	 */
	public function getlist(){
		$arc=new model('article');
		$smarty=new Smarty();
		$this->order='add_time desc,aid desc';
		$field='aid,title,fid,photo,source,add_time,hits,status,highlight,property,links';
		$arr=$arc->where($this->where)->order($this->order)->page($smarty, array('','','',''))->select($field);
		$data=array(
				'list'=>$arr,
				"tab"=>'?action=news&operation=delete',);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'news_list.htm');
	}

	/**
	 *添加视图
	 */
	public function view(){
		$smarty=new Smarty();
		$arc=new model('article');
		$eid=C::get('id');
		$field='aid,title,fid,uid,photo,readperm,source,status,highlight,property,seotitle,keywords,description,links,label,intro,discuss,add_time';
		$data_multi=array('property_options'=>$this->property,'discuss_options'=>$this->pr);
		$smarty->assign('fid_options',$this->selectf());
		if (!empty($eid)){
			$smarty->assign("tab","?action=news&operation=save&id=".$eid);
			$data=$arc->where('aid='.$eid)->select($field);
			$data=$data[0];
			$des=new model('article_descrip');
			//描述
			$des_data=$des->where('aid='.$eid)->getField('content');
			$smarty->assign('content',C::noHtmlRepace($des_data));
			$smarty->assign('property',explode(',', $data['property']));
			$smarty->assign($data);
		}else{
			$smarty->assign("tab","?action=news&operation=save");
			$field_array=explode(',', $field);
			for ($i=0;$i<count($field_array);$i++){
				$smarty->assign($field_array[$i],'');
			}
			$smarty->assign('add_time',time());
			$smarty->assign('content','');
		}
		$smarty->assign($data_multi);
		$smarty->display(DEFAUTL_PATH.'news_info.htm');
	}

	/**
	 *更新某值
	 */
	public function asy(){
		$arc=new model('article');
		$id=$_POST['id'];
		$fd=$_POST['fd'];//字段
		$val=$_POST['val'];//值
		$data=array($fd=>$val);
		$arc->data($data)->where('id='.$id)->save();
	}
	
	/**
	 *更新某值
	 */
	public function classasy(){
		$goods=new model('article_classify');
		$id=$_POST['id'];
		$fd=$_POST['fd'];//字段
		$val=$_POST['val'];//值
		$data=array($fd=>$val);
		$goods->data($data)->where('fid='.$id)->save();
	}

}

?>