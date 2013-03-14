<?php
/**
 * 按分类调用产品
 * Enter description here ...
 */
function getindex(){
	$goods=new model('goods');
	$gtype=new model('goods_classify');
	$result=array();
	$g_list=$gtype->order('sort asc,fid asc')->where("display='Y' and upid=0")->select('fid,title');
	foreach ($g_list as $r){
		$sub1=array();
		$arr1=$goods->where('fid in (select fid from cms_goods_classify where upid='.$r['fid'].')')->order('pid asc')->limit(8)->select('pid,title,photo,price1');
		foreach ($arr1 as $s1){
			$sub1[]=array(
					'pid'=>$s1['pid'],
					'title'=>$s1['title'],
					'photo'=>smallimg(UPLOAD_PATH.$s1['photo']),
					'price1'=>$s1['price1'],
			);
		}
		$sub2=array();
		$arr2=$goods->where('fid in (select fid from cms_goods_classify where upid='.$r['fid'].')')->order('pid asc')->limit(5)->select('pid,title,photo,price1');
		foreach ($arr2 as $s2){
			$sub2[]=array(
					'pid'=>$s2['pid'],
					'title'=>$s2['title'],
					'photo'=>smallimg(UPLOAD_PATH.$s2['photo']),
					'price1'=>$s2['price1'],
			);
		}
		$result[]=array(
				'fid'=>$r['fid'],
				'title'=>$r['title'],
				'sub1'=>$sub1,
				'sub2'=>$sub2,
		);
	}
	return $result;
}

//推荐产品
function tj(){
	$goods=new model('goods');
	$field='pid,title,price1,photo';
	$g_data=$goods->where('istop=1')->order('add_time desc,pid desc')->limit(5)->select($field);
	$result=array();
	foreach ($g_data as $r){
		$result[]=array(
				'pid'=>$r['pid'],
				'title'=>$r['title'],
				'photo'=>smallimg(UPLOAD_PATH.$r['photo']),
				'price1'=>$r['price1'],
		);
	}
	return $result;
}

function smallimg($photo){
	//$fname='http://localhost/upload/1302/07Feb2013192533.jpg';
	$p=substr($photo,0,strripos($photo, '/')+1);//路径
	$rand_name=substr($photo,strripos($photo, '/')+1);
	$a=substr($rand_name,0, strpos($rand_name, '.'));//图片名
	$b=substr($rand_name,strpos($rand_name, '.'));//格式
	$result='';
	if (file_exists($p.$a.'s'.$b)){
		$result=$p.$a.'s'.$b;
	}else{
		$result=$photo;
	}
	return $result;
}