<?php
function artclass($table='article_classify'){
	$gtype=new model($table);
	$field='fid,title,upid';
	$arr_1=$gtype->where('upid=0')->order('fid desc')->select($field);
	$nav=array('0'=>'第一级分类');
	if (is_array($arr_1))
	{
		foreach ($arr_1 as $row_1)
		{
			$nav+=array($row_1['fid']=>$row_1['title']);
			if ($gtype->where('upid='.$row_1['fid'])->getField($field)>0){
				$arr_2=$gtype->where('upid='.$row_1['fid'])->order('fid asc')->select($field);
				foreach ($arr_2 as $row_2){
					$nav+=array($row_2['fid']=>'－'.$row_2['title']);									
				}
			}
		}
	}
	return $nav;
}