<?php
include '../init.php';
include MODEL_PATH.'Area_NewsDiscussModel.php';
include MODEL_PATH.'Member_UserModel.php';

/**
 *新闻评论
 */
$d=new Area_NewsDiscussModel();
if (isset($_GET['type']) && isset($_GET['id'])){
	$type=$_GET['type'];
	$id=Common::isint($_GET['id']);
	switch ($type){
		case "news":
			echo $d->getCount("typeid='N' and news_id=".$id);
			exit(0);
			break;
		case "baike":
			echo $d->getCount("typeid='B' and news_id=".$id);
			exit(0);
			break;
		default:echo 0;
	}
}

/*
 *
 */
if (isset($_GET['act'])){
	session_start();
	$act=$_GET['act'];
	$v_code=$_POST['txt_code'];
	if ($_SESSION["code"]==$v_code){//return -1
		switch ($act){
			case "news":
				$val=trim($_POST['val']);
				if (!empty($val)){
					$eid=Common::isint($_POST['id']);
					$data=array("news_id"=>$eid,
								"user_id"=>$m_uid,
								"add_time"=>date("Y-m-d H:i:s",strtotime("now")),
								"add_ip"=>Common::GetIp(),
								"content"=>$val);
					echo $d->add($data);
					unset($_SESSION["code"]);
					exit(0);
				}
				else {
					echo "-2";exit(0);
				}
				break;
			case "baike":
				$val=trim($_POST['val']);
				if (!empty($val)){
					$eid=Common::isint($_POST['id']);
					$data=array("news_id"=>$eid,
									"user_id"=>$m_uid,
									"add_time"=>date("Y-m-d H:i:s",strtotime("now")),
									"add_ip"=>Common::GetIp(),
									"content"=>$val,
									"typeid"=>"B");
					echo $d->add($data);
					unset($_SESSION["code"]);
					exit(0);
				}
				else {
					echo "-2";exit(0);
				}
				break;
			case "es":
				include MODEL_PATH.'Classify_guestModel.php';
				$val=trim($_POST['val']);
				if (isset($_GET['typeid']) && !empty($val)){
					$data=array("classify_type"=>Common::isint($_GET['typeid']),
									"classify_id"=>Common::isint($_POST['id']),
									"user_id"=>$m_uid,
									"content"=>Common::htmlRepace($val),
									"add_time"=>strtotime('now'),
									"add_ip"=>Common::GetIp(),);
					$control=new Classify_guestModel();
					$control->add($data);
					unset($_SESSION["code"]);
				}
				else {
					echo "-2";exit(0);
				}
				break;
		}
	}else{
		echo "-1";
		exit(0);
	}
}

/*
 * 会员
 */
if (isset($_GET['chk'])){
	switch ($_GET['chk']){
		case "userid":
			if (isset($_GET['checkid']) && !empty($_GET['checkid'])){
				$chkid=$_GET['checkid'];
				$userControl=new Member_UserModel();
				$ii=$userControl->getCount("username='".$chkid."'");
				echo $ii;
				exit(0);
			}
			break;
		case "useremail":
			if (isset($_GET['checkid']) && !empty($_GET['checkid'])){
				$chkid=$_GET['checkid'];
				$userControl=new Member_UserModel();
				$ii=$userControl->getCount("email='".$chkid."'");
				echo $ii;
				exit(0);
			}
			break;
		case "nickname":
			if (isset($_GET['checkid']) && !empty($_GET['checkid'])){
				$chkid=$_GET['checkid'];
				$userControl=new Member_UserModel();
				$ii=$userControl->getCount("nickname='".$chkid."'");
				echo $ii;
				exit(0);
			}
			break;
		case "getname":
			if (isset($_GET['checkid']) && !empty($_GET['checkid'])){
				$userControl=new Member_UserModel();
				$chkid=$_GET['checkid'];
				echo $userControl->getField('username', 'uid='.$chkid);
			}
			break;
	}
}

/*
 * 二手信息数
 */
if (isset($_GET['tab'])){
	switch ($_GET['tab']){
		case "buyhouse":
			include MODEL_PATH.'Classify_buyhouseModel.php';
			$control=new Classify_buyhouseModel();
			$where='';
			if (isset($_GET['classid']) && !empty($_GET['classid'])){
				$where.="classid=".Common::isint($_GET['classid'])."";
			}
			if (isset($_GET['buy_type']) && !empty($_GET['buy_type'])){
				$where.="buy_type=".Common::isint($_GET['buy_type'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "sellhouse":
			include MODEL_PATH.'Classify_sellhouseModel.php';
			$control=new Classify_sellhouseModel();
			$where='';
			if (isset($_GET['classid']) && !empty($_GET['classid'])){
				$where.="classid=".Common::isint($_GET['classid'])."";
			}
			if (isset($_GET['sell_type']) && !empty($_GET['sell_type'])){
				$where.="sell_type=".Common::isint($_GET['sell_type'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "recruitment":
			include MODEL_PATH.'Classify_recruitmentModel.php';
			$control=new Classify_recruitmentModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "job":
			include MODEL_PATH.'Classify_jobModel.php';
			$control=new Classify_jobModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "content":
			include MODEL_PATH.'Classify_contentModel.php';
			$control=new Classify_contentModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "friend":
			include MODEL_PATH.'Classify_friendModel.php';
			$control=new Classify_friendModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "recruitment":
			include MODEL_PATH.'Classify_recruitmentModel.php';
			$control=new Classify_recruitmentModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "part":
			if (isset($_GET['cid']) && !empty($_GET['cid'])){
				include ACTION_PATH.'Classify_partAction.php';
				$part=new Classify_partAction();
				echo $part->displayClass1($_GET['cid']);
			}
			break;
		case "part2":
			if (isset($_GET['partid']) && !empty($_GET['partid'])){
				include ACTION_PATH.'Classify_partAction.php';
				$part=new Classify_partAction();
				echo $part->selectAjax("level_id=".Common::isint($_GET['partid']),'fabu_twoclass');
			}
			break;
		case "pinglun":
			if (isset($_GET['eid']) && !empty($_GET['eid']) && isset($_GET['tid']) && !empty($_GET['tid'])){
				$eid=Common::isint($_GET['eid']);
				$tid=Common::isint($_GET['tid']);
				include MODEL_PATH.'Classify_guestModel.php';
				$part=new Classify_guestModel();
				echo $part->getCount("classify_type=".$tid." and classify_id=".$eid."");
				//echo $tid;
			}
			break;
		case "answer":
			if (isset($_GET['cid']) && !empty($_GET['cid'])){
				include MODEL_PATH.'Other_AnswerModel.php';
				$answer=new Other_answerModel();
				echo $answer->getCount("know_id=".Common::isint($_GET['cid']));
				exit(0);
			}
			break;
		case "yellowyages":
			include MODEL_PATH.'Yellowyages_contentModel.php';
			$yp=new Yellowyages_contentModel();
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$yp->getCount($where);
			echo $num;
			break;
		case "lptuan":
			include ACTION_PATH.'House_tuanAction.php';
			$tuan=new House_tuanAction();
			echo $tuan->add();
			break;
		default:die("error!");
	}
}

/**
 * 商家信息
 */

if (isset($_GET['tmall'])){
	switch ($_GET['tmall']){
		case "member":
			include MODEL_PATH.'Tmall_infoModel.php';
			$control=new Tmall_infoModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "type":
			if (isset($_GET['cid']) && !empty($_GET['cid'])){
				include ACTION_PATH.'Tmall_typeAction.php';
				$part=new Tmall_typeAction();
				echo $part->displayClass1($_GET['cid']);
			}
			break;
		case "product":
			include MODEL_PATH.'Tmall_productModel.php';
			$control=new Tmall_productModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "content":
			include MODEL_PATH.'Classify_contentModel.php';
			$control=new Classify_contentModel();
			$where='';
			if (isset($_GET['classid_b']) && !empty($_GET['classid_b'])){
				$where.="classid_b=".Common::isint($_GET['classid_b'])."";
			}
			if (isset($_GET['classid_a']) && !empty($_GET['classid_a'])){
				$where.="classid_a=".Common::isint($_GET['classid_a'])."";
			}
			if (isset($_GET['classid_t']) && !empty($_GET['classid_t'])){
				$where.="classid_t=".Common::isint($_GET['classid_t'])."";
			}
			$num=$control->getCount($where);
			echo '('.$num.')';
			break;
		case "products1":
			include ACTION_PATH.'Goods_classifyAction.php';
			$control=new Goods_classifyAction();
			if (isset($_GET['partid']) && !empty($_GET['partid'])){
				$partid=Common::isint($_GET['partid']);
				echo $control->selectTwo('level_id='.$partid,"twoclass");
				exit(0);
			}
			break;
		case "products2":
			include ACTION_PATH.'Goods_classifyAction.php';
			$control=new Goods_classifyAction();
			if (isset($_GET['partid']) && !empty($_GET['partid'])){
				$partid=Common::isint($_GET['partid']);
				echo $control->selectTwo('level_id='.$partid,"threeclass");
				exit(0);
			}
			break;
	}

}

?>