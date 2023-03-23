<?php
header('Content-Type:application/json; charset=utf-8');
include_once ("connect.php");
$userID=$_GET['userID'];
$password=$_GET['password'];
$sql="select * from `accountinfo` where userName='$userID'";
$result=mysqli_query($con,$sql);
$num_result = mysqli_num_rows($result);
$msg = array();
if($num_result==1){
	$row=mysqli_fetch_array($result);
	$pwd = $row['passWord'];
	if($pwd==$password){
		$authKey = $row['authKey'];
		$accountDBID = $row['accountDBID'];
		$msg = array('msg'=>'success','ReturnCode' => 0,'Return'=>true,'Permission'=>'0','AuthKey'=>$authKey,'UserNo'=>$accountDBID);
	}else{
		$userName = $row['userName'];
		$msg = array('msg'=>'userId '.$userID.' pwd error','ReturnCode' => 2,'Return'=>false);
	}
}else{
	$msg = array('msg'=>'account not exist','ReturnCode' => 50001,'Return'=>false);
}
echo json_encode($msg,JSON_UNESCAPED_UNICODE);
mysqli_close($con);
?>