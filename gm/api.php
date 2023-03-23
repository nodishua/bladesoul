<?php
include_once ("config.php");
error_reporting(0);
session_start();
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];
$gmcode = $_POST['gmcode'];
$type = $_POST['type'];
$num = $_POST['num'];
$item = $_POST['item'];
$return = array('code' => 501,'msg' => 'uid is empty');
$num == '' && ($num = '1'); 
if($uid==''){
	exit(json_encode($return));
	return;
}
switch($type){
	case 'login':
		if($gmcode==$GMCode){
			$query="select * from `accountinfo` where userName='$uid'";
			$result=mysqli_query($mysql,$query);
			$result_row = mysqli_num_rows($result);
			if($result_row==1){
				$row=mysqli_fetch_array($result);
				if($row['passWord']==$pwd){
					$vipfile=$vip.$quid.'.json';
					$fp = fopen($vipfile,"a+");
					if(filesize($vipfile)>0){
						$str = fread($fp,filesize($vipfile));
						fclose($fp);
						$vipjson=json_decode($str,true);
						if($vipjson==null){
							$vipjson=array();
						}
					}else{
						$vipjson=array();
					}
					$_SESSION['uid']=$uid;
					$_SESSION['level']=intval($vipjson[$uid]['level']);
					$return = array(
						'code' => 200,
						'msg' => 'login successful'
					);
				}else{
					$return = array(
						'code' => 503,
						'msg' => 'Account password error'
				);
				}
			}else{
				$return = array(
					'code' => 502,
					'msg' => 'Account does not exist'
				);
			}
		}else{
			$return = array(
					'code' => 500,
					'msg' => 'Authorized password error'
			);
		}
		exit(json_encode($return));
		break;
	case 'mail':
		$level = $_SESSION['level'];
		if($level < 2){
			die("No authority！");
		}
		$item == '' && (die('No choice')); 
		#$query="insert into recharge (userid, goodid, qty) values ('$uid','$items','$num')";
		#$result = mysqli_query($sqlsrv,$query);
		echo sendMail($item,$num,$uid);
		break;
	case 'charge':
		$level = $_SESSION['level'];
		if($level < 1){
			die("No authority！");
		}
		die("No recharge！");
	case 'delmail':
		echo delMailForAccountId($uid);
		break;
	default:
		$return=array(
			'errcode'=>588,
			'info'=>'data error',
		);
		exit(json_encode($return));
		break;
}