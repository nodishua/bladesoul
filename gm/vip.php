<?php
include_once ("config.php");
error_reporting(0);
$sqm = $_POST['sqm'];
$uid = $_POST['uid'];
$num = $_POST['num'];
$item = $_POST['item'];
$sqm != $GMSQM && (die('Mã ủy quyền sai')); 
$return = array('code' => 501,'msg' => 'uid为空');
$type = $_POST['type'];
$num == '' && ($num = '1');
$uid == '' && (die('Không có tên tài khoản'));
switch($type){
	case 'charge':
		die("Không nạp tiền");	
		break;
	case 'mail':
		$item == '' && (die('Không có vật phẩm nào được chọn'));
		if(sendMail($item,$num,$uid)){
			die("Gửi thành công");
		}else{
			die("Gửi thất bại");
		}
		break;
	case 'addvip1':
		addvip(1,$uid,$quid);
		die('VIP1 đã mở thành công');
		break;
	case 'addvip2':
		addvip(2,$uid,$quid);
		die('VIP2 đã mở thành công');
		break;
	case 'delmail':
		echo delMailForAccountId($uid);
		break;
	default:
		die('Hoạt động không xác định');
		break;
}
function addvip($level,$uid,$quid){
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
	$vipjson[$uid]=array('level'=>$level);
	file_put_contents($vipfile,json_encode($vipjson));
};
?>