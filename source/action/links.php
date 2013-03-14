<?php
class links {
	protected $where='',$order='';
	private $tcolor=array(""=>"无","#ff0000"=>"红色");
	function __construct(){
	}

	/**
	 * 添加
	 */
	public function save(){
		$sort=C::get('sort');
		$sitename=C::get('sitename');
		$url=C::get('url');
		$description=C::get('description');
		$logo=C::get('logo');
		$data=array();
		for ($i=0;$i<count($sort);$i++){
			if (!empty($sort[$i]) && !empty($sitename[$i]) && !empty($url[$i]))
			$data[]=array(
					'sort'=>$sort[$i],
					'sitename'=>$sitename[$i],
					'url'=>$url[$i],
					'description'=>$description[$i],
					'logo'=>$logo[$i]
				);
		}
		$links=new model('links');
		$links->data($data)->addAll();
		C::msg('', $_SERVER['HTTP_REFERER']);
	}

	/**
	 *批量删除
	 */
	public function delete(){
		$links=new model('links');
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		$result=$links->where('id in ('.$idarr.')')->delete();
		C::msg('', $_SERVER['HTTP_REFERER']);
	}


	/**
	 * 查找前几条记录
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 */
	public function selectTop($where,$order,$limit){
		$links=new model('links');
		$data=$links->where($where)->order($order)->limit($limit)->select();
		return $data;
	}

	/**
	 *查找
	 */
	public function getlist(){
		$links=new model('links');
		$smarty=new Smarty();
		$url='';
		$field='id,type,sitename,url,logo,description,status,end_time,sort';
		$arr=$links->where($this->where)->order($this->order)->select($field);
		$data=array(
				'tab'=>'?action=links&operation=save',
				'list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'links_list.htm');
	}

	/**
	 *更新某值
	 */
	public function asy(){
		$arc=new model('links');
		$id=$_POST['id'];
		$fd=$_POST['fd'];//字段
		$val=$_POST['val'];//值
		$data=array($fd=>$val);
		$arc->data($data)->where('id='.$id)->save();
	}
	
	public function gettu(){
		$tu=new model('tu');
		$smarty=new Smarty();
		$field='id,sort,title,url,attach';
		$arr=$tu->where($this->where)->select($field);
		$data=array(
				'tab'=>'?action=links&operation=savetu',
				'list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'set_tu.htm');
	}
	
	public function savetu(){
		$tu=new model('tu');
		$sort=get('sort');
		$title=get('title');
		$url=get('url');
		$attach=get('attach');
		$data=array();
		for($i=0;$i<count($title);$i++){
			$data[]=array(
					'sort'=>$sort[$i],
					'title'=>$title[$i],
					'url'=>$url[$i],
					'attach'=>$attach[$i]
					);
		}
		$tu->data($data)->addAll();
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	//删除
	public function deletetu(){
		$chkid=get('check_id');
		//$idlist=implode(',', $id);
		$tu=new model('tu');
		for($i=0;$i<count($chkid);$i++){
			$pic=explode('|', $chkid[$i]);
			if (file_exists(ROOT_PATH.$pic[1])){
				unlink(ROOT_PATH.$pic[1]);
			}
			$tu->where("id=$pic[0]")->delete();
		}
		C::msg('', '/source/redirect.php?msg=操作完成&url='.urlencode($_SERVER['HTTP_REFERER']));
	}
	
	public function getad(){
		global $smarty;
		$ad=new model('ad');
		$field='`id`,`title`,`fid`,`tag`,`start_time`,`end_time`,`ad_type`,`codes`,`word`,`links`,`image`,`image_txt`,`ad_w`,`ad_h`,`flash_url`,`closed`,`sort`';
		$arr=$ad->where($this->where)->order($this->order)->page($smarty, array('','','',''))->select($field);
		$smarty->assign('list',$arr);
		$smarty->display(DEFAUTL_PATH.'ad_list.htm');
	}
	
	public function adview(){
		global $smarty;
		$smarty->display(DEFAUTL_PATH.'ad_info.htm');
	}

}

?>