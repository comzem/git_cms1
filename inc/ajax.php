<?php
require dirname(dirname(__FILE__)).'/inc/init_cms.php';
$t=C::get('t');
switch ($t){
	case 'g_exp':
		$g_exp=new model('goods_expand1');
		$id=C::get('id');
		if (empty($id)){
			echo '';
			exit(0);
		}
		$field='fieldid,available,title,description,formtype,size,choices,validate,style';
		$exp=$g_exp->where('fid='.$id)->order('sort asc')->select($field);
		$result='';
		foreach ($exp as $k){
			$result.='';
		}
		echo '货号<input type="text" name="ee" />';
		exit(0);
		break;
	case 'cart':
		include ACTION_PATH.'orders.php';
		$order=new orders();
		if (isset($_GET['edit_num']) && isset($_GET['edit_id'])){
			$num=C::isint(C::get('edit_num'));//数量
			$pid=C::isint(C::get('edit_id'));//商品ID
			$order->edit_order_num($pid, $num);
			exit(0);
		}
		break;
	case 'cnum':
		if (isset($_SESSION['order_item'])){
			echo count($_SESSION['order_item']);
			exit(0);
		}else{
			echo 0;
			exit(0);
		}
		break;
	case 'delete_order':
		include ACTION_PATH.'orders.php';
		$order=new orders();
		$id=C::get('id');
		if (!empty($id)){
			echo $order->delete_order($id);
			exit(0);
		}
		break;
	case 'addradd':
		include ACTION_PATH.'members.php';
		$user=new members();
		echo $user->saveaddr();
		exit(0);
		break;
	case 'area':
		$t=C::get('txt');
		if (!empty($t)){
			$area=new model('areas');
			$field='area_id,area_name';
			$id=$area->where("locate(area_name,'$t')")->getField('area_id');			
			$data=$area->where('parent_id='.$id)->select($field);
			$city="<option value=\"\">请选择...</option>";
			foreach ($data as $row){
				$city.="<option value=\"".$row['area_name']."\">".$row['area_name']."</option>";
			}
			echo $city;
			exit(0);
		}
		break;
	case 'logout':
		include ACTION_PATH.'members.php';
		$user=new members();
		$user->logout($_SERVER['HTTP_REFERER']);
		break;
	case 'user_status':
		if (isset($_SESSION['auth_user'])){
			echo 1;
		}else{
			echo 0;
		}
		exit(0);
		break;
	case 'mydb':
		require ACTION_PATH.'tools.php';
		$tool=new tools();
		$tablename=C::get('table');
		$act=C::get('act');
		switch ($act){
			case 'dbback':
				$tool->dbback($tablename);
				break;
			case 'dbrestore':
				$tool->dbrestore($tablename);
				break;
			case 'repair':
				$tool->repair($tablename);
				echo 1;
				break;
			case 'optimize':
				$tool->optimize($tablename);
				echo 1;
				break;
		}
		exit(0);
		break;
	case 'goods_comments'://商品评论
		if ($_CFG['interactive'][5]=='1'){
			echo -4;
			exit(0);
		}
		if (!isset($_SESSION['auth_user'])){
			echo -1;
			exit(0);
		}
		if (!isset($_SESSION['send_time'])){
			$_SESSION['send_time']=time();
			$resultid=goods_comments($_CFG['interactive'][2]);
		}else{
			if (time()-$_SESSION['send_time']<$_CFG['interactive'][4]*60){
				echo -2;
				exit(0);
			}else{
				$_SESSION['send_time']=time();
				$resultid=goods_comments($_CFG['interactive'][2]);
			}
		}		
		echo $resultid;
		exit(0);
		break;
	case 'comments_total':
		$comments=new model('goods_comments');
		$fid=get('fid');
		$pid=get('pid');
		$total=$comments->where("fid=$fid and pid=$pid")->getField('count(pid)');
		echo $total>0?$total:0;
		break;
	case 'comments'://普通留言
		if ($_CFG['interactive'][5]=='1'){
			echo -4;
			exit(0);
		}
		if (!isset($_SESSION['send_time'])){
			$_SESSION['send_time']=time();
			$resultid=comments($_CFG['interactive'][2]);
		}else{
			if (time()-$_SESSION['send_time']<$_CFG['interactive'][4]*60){
				echo -2;
				exit(0);
			}else{
				$_SESSION['send_time']=time();
				$resultid=comments($_CFG['interactive'][2]);
			}
		}
		echo $resultid;
		exit(0);
		break;
}
//$closed：1 审核中
function goods_comments($closed){
	$pid=get('pid');
	$uid=get('uid');
	$username=get('username');
	$content=get('content');
	$fid=get('fid');
	$data=array(
			'pid'=>$pid,
			'uid'=>$uid,
			'username'=>$username,
			'content'=>C::LeftStr($content, 255),
			'fid'=>$fid,
			'add_time'=>time(),
			'closed'=>$closed
	);
	$comments=new model('goods_comments');
	$resultid=$comments->data($data)->add();
	return $closed=='0'?-3:$resultid;
}

function comments($closed){
	$content=get('content');
	$data=array(
			'subject'=>get('title'),
			'authorid'=>$uid,
			'author'=>$username,
			'dateline'=>time(),
			'closed'=>$closed
	);
	$comments=new model('goods_comments');
	$resultid=$comments->data($data)->add();
	return $closed=='0'?-3:$resultid;
}

//$str被替换
function replace($str,$rep){

}