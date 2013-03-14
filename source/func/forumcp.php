<?php
class forumcp{
	private $smarty;
	function __construct($smarty){
		$this->smarty=$smarty;
		$mod=C::get('mod');
		if (!empty($mod)){
			$this->$mod();
		}else{
			$this->forum();
		}
	}
	
	public function forumdisplay(){
		$th=new model('forum');
		$this->smarty->display(DEFAUTL_PATH.'forum/forumdisplay.htm');
	}
	
	public function viewthread(){
		
	}
	
	public function forum(){
		$gtype=new model('forum_classify');
		$field='fid,title,upid,sort,lastpost';
		$arr_1=$gtype->where('upid=0')->order('sort asc,fid asc')->select($field);
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
								'upid'=>$row_2['upid'],
								'sort'=>$row_2['sort'],
								'lastpost'=>$row_2['lastpost']
						);
					}
				}
				$nav[]=array('fid'=>$row_1['fid'],
						'title'=>$row_1['title'],
						'upid'=>$row_1['upid'],
						'sort'=>$row_1['sort'],
						'lastpost'=>$row_1['lastpost'],
						'sub'=>$sub_0);
			}
		}
		$this->smarty->assign('nav',$nav);
		$this->smarty->display(DEFAUTL_PATH.'forum/forum.htm');
	}
}