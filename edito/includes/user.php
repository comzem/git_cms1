<?php
header("Content-Type:text/html;charset=utf-8");
include '../init.php';
include ACTION_PATH.'Member_userlogAction.php';

switch(@$_GET['act']) {
	case 'login':
		//通过接口判断登录帐号的正确性，返回值为数组
		list($uid, $username, $password, $email) = uc_user_login($_POST['username'], $_POST['password']);
		setcookie('user_auth', '', -86400);
		if($uid > 0) {
			//用户登陆成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
			setcookie('user_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
			//生成同步登录的代码
			$ucsynlogin = uc_user_synlogin($uid);
			echo $ucsynlogin;
			//echo '登录成功'.$ucsynlogin.'<br><a href="'.$_SERVER['PHP_SELF'].'">继续</a>';
			echo $username;
			$userlog=new Member_userlogAction();
			$userlog->add($uid);
			exit;
		}else{
			echo $uid;
		}
		break;
	case 'logout':
		//UCenter 用户退出的 Example 代码
		setcookie('user_auth', '', -86400);
		//生成同步退出的代码
		$ucsynlogout = uc_user_synlogout();
		echo '退出成功'.$ucsynlogout.'<br><a href="'.$_SERVER['PHP_SELF'].'">继续</a>';
		echo "<script>location.href='".$_SERVER['HTTP_REFERER']."'</script>";
		exit();
		break;
	case 'userStatus':
		if(empty($_COOKIE['user_auth'])){
			echo '0';
			exit();
		}else{
			echo '1';
			exit();
		}
		break;
	case 'register':
		break;
	case 'content':
		if (isset($_GET['id'])){
			include MODEL_PATH.'Classify_contentModel.php';
			$model=new Classify_contentModel();
			$userid=$model->getField('user_id', 'id='.Common::isint($_GET['id']));
			if ($userid==0){//非用户
				echo -1;
			}else{
				if($m_uid!=0) {
					if ($userid==$m_uid){//是用户且帐号对
						echo 1;
					}else{
						echo -3;//不是此会员发布的
					}
				}else{//是用户时，未登陆，返回-2，要求登陆
					echo -2;
				}
			}
		}
		break;
	case 'zhaopin':
		if (isset($_GET['id'])){
			include MODEL_PATH.'Classify_recruitmentModel.php';
			$model=new Classify_recruitmentModel();
			$userid=$model->getField('user_id', 'id='.Common::isint($_GET['id']));
			if ($userid==0){//非用户
				echo -1;
			}else{
				if($m_uid!=0) {
					if ($userid==$m_uid){//是用户且帐号对
						echo 1;
					}else{
						echo -3;//不是此会员发布的
					}
				}else{//是用户时，未登陆，返回-2，要求登陆
					echo -2;
				}
			}
		}
		break;
	case 'sellhouse':
		if (isset($_GET['id'])){
			include MODEL_PATH.'Classify_sellhouseModel.php';
			$model=new Classify_sellhouseModel();
			$userid=$model->getField('user_id', 'id='.Common::isint($_GET['id']));
			if ($userid==0){//非用户
				echo -1;
			}else{
				if($m_uid!=0) {
					if ($userid==$m_uid){//是用户且帐号对
						echo 1;
					}else{
						echo -3;//不是此会员发布的
					}
				}else{//是用户时，未登陆，返回-2，要求登陆
					echo -2;
				}
			}
		}
		break;
	case 'buyhouse':
		if (isset($_GET['id'])){
			include MODEL_PATH.'Classify_buyhouseModel.php';
			$model=new Classify_buyhouseModel();
			$userid=$model->getField('user_id', 'id='.Common::isint($_GET['id']));
			if ($userid==0){//非用户
				echo -1;
			}else{
				if($m_uid!=0) {
					if ($userid==$m_uid){//是用户且帐号对
						echo 1;
					}else{
						echo -3;//不是此会员发布的
					}
				}else{//是用户时，未登陆，返回-2，要求登陆
					echo -2;
				}
			}
		}
		break;
	case 'friend':
		if (isset($_GET['id'])){
			include MODEL_PATH.'Classify_friendModel.php';
			$model=new Classify_friendModel();
			$userid=$model->getField('user_id', 'id='.Common::isint($_GET['id']));
			if ($userid==0){//非用户
				echo -1;
			}else{
				if($m_uid!=0) {
					if ($userid==$m_uid){//是用户且帐号对
						echo 1;
					}else{
						echo -3;//不是此会员发布的
					}
				}else{//是用户时，未登陆，返回-2，要求登陆
					echo -2;
				}
			}
		}
		break;
}

