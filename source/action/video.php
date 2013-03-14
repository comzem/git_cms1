<?php
class video {
	function __construct(){
	}

	/**
	 * 添加
	 */
	public function add(){
		$data=array(
				"fid"=>C::isint(C::get('fid')),
				"title"=>C::LeftStr(C::get('title'),50),
				"video_img"=>C::LeftStr(C::get('video_img'),50),
				"video_path"=>C::LeftStr(C::get('video_path'),200),
				"details"=>C::htmlRepace(C::get('details')),
				"uid"=>'1',
				"add_time"=>time()
		);
		$video=new model('video');
		$video->data($data)->add();
	}

	/**
	 *批量删除
	 */
	public function delete(){
		$idarr=$_POST['check_id'];
		$result=$this->Action->delete('id in ('.implode(",", $idarr).')');
		return $result;
	}
	
	/**
	 * 添加
	 */
	public function addclass(){
		$msg='保存成功！';
		$add_sort=$_POST['add_sort'];
		$add_title=$_POST['add_title'];
		$add_level_id=$_POST['add_level_id'];
		$count_add=count($add_sort);
		$data=array();
		for($i=0;$i<$count_add;$i++){
			if (isset($add_title[$i]) && !empty($add_title[$i]) && isset($add_sort[$i]) && !empty($add_sort[$i])){
				$data[]=array(
						"video_title"=>Common::LeftStr($add_title[$i],50),
						"level_id"=>$add_level_id[$i]=='0'?0:Common::isint($add_level_id[$i]),
						"sort"=>Common::isint($add_sort[$i])
				);
			}else{
				$msg='请填写完整';
			}
		}
		$result=$this->Action->addAll($data);
		return $msg;
	}
	/**
	 *查找
	 */
	public function getclass($pagesize=15,$where='',$order,$pagurl,$smarty){
		$smarty->assign("tab","list");
		$arr_1=$this->Action->select($where,$order);
		$nav=array();
		if (is_array($arr_1))
		{
			foreach ($arr_1 as $row_1)
			{
				/////////////////////////
				$sub_0=array();
				if ($this->Action->getCount('level_id='.$row_1['id'])>0){
					$arr_2=$this->Action->select('level_id='.$row_1['id']);
					foreach ($arr_2 as $row_2){
						/////////////////////////
						$sub_1=array();
						if ($this->Action->getCount('level_id='.$row_2['id'])>0){
							$arr_3=$this->Action->select('level_id='.$row_2['id']);
							foreach ($arr_3 as $row_3){
								$sub_1[]=array('id'=>$row_3['id'],
										'newc_title'=>$row_3['video_title'],
										'newc_upid'=>$row_3['level_id'],
										'newc_sort'=>$row_3['sort']);
							}
						}
						////////////////////////
						$sub_0[]=array('id'=>$row_2['id'],
								'newc_title'=>$row_2['video_title'],
								'newc_upid'=>$row_2['level_id'],
								'newc_sort'=>$row_2['sort'],'sub1'=>$sub_1);
					}
				}
				///////////////////////////
				$nav[]=array('id'=>$row_1['id'],
						'newc_title'=>$row_1['video_title'],
						'newc_upid'=>$row_1['level_id'],
						'newc_sort'=>$row_1['sort'],
						'sub'=>$sub_0);
			}
		}
		$smarty->assign("nav",$nav);
	}

	/**
	 * 查找前几条记录
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 */
	public function selectTop($secion,$where,$order,$limit,$smarty){
		$arr=$this->Action->select($where,$order,$limit);
		$listarr=array();
		if (is_array($arr))
		{
			foreach ($arr as $row)
			{
				$listarr[]=array("id"=>$row['id'],"classid_b"=>$row['classid_b'],"classid_a"=>$row['classid_a'],"classid_t"=>$row['classid_t'],"title"=>$row['title'],"video_img"=>$row['video_img'],"video_path"=>$row['video_path'],"details"=>$row['details'],"user_id"=>$row['user_id'],"tmall_id"=>$row['tmall_id'],"add_time"=>$row['add_time'],"add_ip"=>$row['add_ip']);
			}

		}
		$smarty->assign($secion,$listarr);
	}

	/**
	 *查找
	 */
	public function select($pagesize=15,$where='',$order,$pagurl,$smarty){
		$smarty->assign("tab","list");
		$page_size=$pagesize;//每页显示的条数
		$nums=$this->Action->getCount($where);//总条目数
		$sub_pages=10;//每次显示的页数
		$pageCurrent=1;
		$offset=0;
		if (isset($_GET["p"]))
		{
			$pageCurrent=$_GET["p"];
			$offset=$page_size*($pageCurrent-1);
		}
		$arr=$this->Action->select($where, $order." limit ".$offset.",".$page_size."");

		$listarr=array();
		if (is_array($arr))
		{
			foreach ($arr as $row)
			{
				$listarr[]=array("id"=>$row['id'],"classid_b"=>$row['classid_b'],"classid_a"=>$row['classid_a'],"classid_t"=>$row['classid_t'],"title"=>$row['title'],"video_img"=>$row['video_img'],"video_path"=>$row['video_path'],"details"=>$row['details'],"user_id"=>$row['user_id'],"tmall_id"=>$row['tmall_id'],"add_time"=>$row['add_time'],"add_ip"=>$row['add_ip']);
			}
		}
		$smarty->assign("list",$listarr);
		$subPages=new SubPages($page_size,$nums,$pageCurrent,$sub_pages,$pagurl,2);
		if($nums>$page_size)
		$smarty->assign("paging",$subPages->subPageCss2());
		else
		$smarty->assign("paging","");
	}

	/**
	 *添加视图
	 */
	public function display1($smarty){
		$smarty->assign("tab","add");
		$classid_b="";$classid_a="";$classid_t="";
		if (isset($_GET['classid_b'])){
			$classid_b=Common::isint($_GET['classid_b']);
		}
		if (isset($_GET['classid_a'])){
			$classid_a=Common::isint($_GET['classid_a']);
		}
		if (isset($_GET['classid_t'])){
			$classid_t=Common::isint($_GET['classid_t']);
		}
		$smarty->assign("txt_classid_b",$classid_b);
		$smarty->assign("txt_classid_a",$classid_a);
		$smarty->assign("txt_classid_t",$classid_t);
		$smarty->assign("txt_title","");
		$smarty->assign("txt_video_img","");
		$smarty->assign("txt_video_path","");
		$smarty->assign("txt_details","");

	}

	/**
	 *修改视图
	 */
	public function display2($smarty){
		$e_id=$_GET['id'];
		$smarty->assign("tab","edit&id=".$e_id);
		$row=$this->Action->find('id='.$e_id);
		if (is_array($row) && count($row)>0)
		{
			$smarty->assign("txt_classid_b",$row[1]);
			$smarty->assign("txt_classid_a",$row[2]);
			$smarty->assign("txt_classid_t",$row[3]);
			$smarty->assign("txt_classid_f",$row[12]);
			$smarty->assign("txt_title",$row[4]);
			$smarty->assign("txt_video_img",$row[5]);
			$smarty->assign("txt_video_path",$row[6]);
			$smarty->assign("txt_details",Common::noHtmlRepace($row[7]));

		}
		unset($e_id);
	}

	public function getField($field,$where){
		return $this->Action->getField($field,$where);
	}

	public function find($where){
		return $this->Action->find($where);
	}


	/**
	 *更新某值
	 */
	public function asy(){
		$id=$_POST['id'];
		$fd=$_POST['fd'];//字段
		$val=$_POST['val'];//值
		if (!empty($val))
		$this->Action->setField("$fd='$val'", 'id='.$id);
	}



}

?>