<?php
#GM config
$quid = 'vip';
$GMSQM = "admin";# 授权码 GM操作密码 不能和GMCode 设置成一样的密码
$GMCode = "123456"; # GM码 用户登录
# sql server config
$SQLSRVDB = 'bnsm_gamedb_trunk_individual';
$SQLSRVUID = 'sa';
$SQLSRVPWD = 'libi@123';
$mysql = mysqli_connect("localhost","root","","bnsmg_accountdb_trunk");
mysqli_query($mysql,"set names utf8");
global $sqlsrv;
$sqlsrv = sqlsrv_connect('localhost', array('Database' => $SQLSRVDB, 'UID' => $SQLSRVUID , 'PWD' => $SQLSRVPWD));
function sendMail($item,$num,$uid){
	$pc_id = getPcId($uid);
	if(strlen($item)<3){
		/*
		#$mail_guid = getMailGuidByAsset($item,$num);
		if($mail_guid==''){
			$mail_guid = time();
			setCharacterMailAsset($mail_guid,$item,$num);
		}
		*/
		$mail_guid = '6'.(string)time();
		setCharacterMailAsset($mail_guid,$item,$num);
		if(setCharacterMail($uid,$pc_id,$mail_guid)){
			return "Submitted successfully";
		}
	}else{
		/*
		#$mail_guid = getMailGuidByItem($item,$num);
		#return json_encode($mail_guid);
		if($mail_guid==''){
			$mail_guid = '8'.(string)time();
			if(setCharacterMailItem($mail_guid,$item,$num)==false){
				return "Item could not be sent".$item.'mail_guid:'.$mail_guid;
			}
		}
		*/
		$mail_guid = '8'.(string)time();
		if(setCharacterMailItem($mail_guid,$item,$num)==false){
			return "Item could not be sent".$item.'mail_guid:'.$mail_guid;
		}
		if(setCharacterMail($uid,$pc_id,$mail_guid)){
			return "Submitted successfully";
		}
	}
	#return json_encode(sqlsrv_errors());
	return "Send failed";
}
# 充值
function sendCharge($num,$uid){
	#TODO
	return false;
}
# 插入角色邮件
function setCharacterMail($account_id,$pc_id,$mail_guid){
	$expire_time = time() + 30*24*3600;
	$sql = "insert into tb_character_mail (account_id,pc_id,mail_guid,mail_recv_type,mail_type,title_id,message,link_url,auction_guid,event_key,expire_time,delete_flag,delete_time,recall_flag,recall_time) values('$account_id','$pc_id','$mail_guid','0','0','System Admin','','','0','-1','$expire_time','0','0','0','0')";
	global $sqlsrv;
	return sqlsrv_query($sqlsrv, $sql);
}
# 插入角色邮件Asset
function setCharacterMailAsset($id,$asset_type,$value){
	$sql = "insert into tb_character_mail_attached_asset (mail_guid,asset_type,value) values('$id','$asset_type','$value')";
	global $sqlsrv;
	return sqlsrv_query($sqlsrv, $sql);
}
# 插入角色邮件item
function setCharacterMailItem($mail_guid,$item_id,$item_count){
	$sql = "insert into tb_character_mail_attached_item (mail_guid,item_guid,item_id,nickname_id,item_count,item_option,moogong_option,jewel_info,item_level,item_exp,enchant_level,duration_count,trade_flag,lock_flag,bless_flag,seal_flag) values('$mail_guid','-1','$item_id','','$item_count','','','','0','0','0','0','0','0','0','0')";
	global $sqlsrv;
	return sqlsrv_query($sqlsrv, $sql);
}
/*
# 获取邮件guid by assert
function getMailGuidByAsset($asset_type,$value){
	$sql = "select mail_guid from tb_character_mail_attached_asset where asset_type='$asset_type' and value='$value'";
	global $sqlsrv;
	$data = sqlsrv_query($sqlsrv, $sql);
	if($data){
		$row = sqlsrv_fetch_array($data);
		return $row['mail_guid'];
	}
	
}
# 获取邮件guid by item
function getMailGuidByItem($item_id,$item_count){
	$sql = "select mail_guid from tb_character_mail_attached_item where item_id='$item_id' and item_count='$item_count'";
	global $sqlsrv;
	$data = sqlsrv_query($sqlsrv, $sql);
	if($data){
		$row = sqlsrv_fetch_array($data);
		return $row['mail_guid'];
	}
}
*/
function getMailGuidForAccountId($account_id){
	$sql = "select mail_guid from tb_character_mail where account_id='$account_id'";
	global $sqlsrv;
	$data = sqlsrv_query($sqlsrv, $sql);
	if($data){
		$array = array();
		while($row=sqlsrv_fetch_array($data)){
			array_push($array,$row['mail_guid']);
		}
		return $array;
	}
}
# 删除用户全部邮件
function delMailForAccountId($uid){
	$data = getMailGuidForAccountId($uid);
	if($data==null){
		return "No mail";
	}
	global $sqlsrv;
	foreach($data as $value){
		$sql = "DELETE FROM tb_character_mail_attached_asset WHERE mail_guid='$value'";
		sqlsrv_query($sqlsrv, $sql);
		$sq11 = "DELETE FROM tb_character_mail_attached_item WHERE mail_guid='$value'";
		sqlsrv_query($sqlsrv, $sq11);
	}
	$sql = "DELETE FROM tb_character_mail WHERE account_id='$uid'";
	global $sqlsrv;
	if(sqlsrv_query($sqlsrv, $sql)){
		return "Complete cleanup！";
	}
}
# 根据用户名获取 pcid
function getPcId($account_id){
	$sql = "select pc_id from tb_character where account_id='$account_id'";
	global $sqlsrv;
	$data = sqlsrv_query($sqlsrv, $sql);
	if($data){
		$row = sqlsrv_fetch_array($data);
		return $row['pc_id'];
	} 
}
?>