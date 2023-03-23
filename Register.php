<?php
header('Content-Type:application/json; charset=utf-8');
include_once ("connect.php");
$userID=$_GET['userID'];
$password=$_GET['password'];
$sql="select * from accountinfo where userName='$userID'";
$result=mysqli_query($con,$sql);
$num_result = mysqli_num_rows($result);
$msg = array();
if($password==''|| $password==null || $userID==null|| $userID=='' ){
	$msg = array('msg'=>'userId '.$userID.' pwd error','ReturnCode' => 2,'Return'=>false);
}else{
	if($num_result==1){
		$msg = array('msg'=>'account exist','ReturnCode' => 50000,'Return'=>false);
	}else{
		$uuid = strtolower(uuid());
		$sql2 = "INSERT INTO accountinfo (userName,passWord,authKey) VALUES ('$userID','$password','$uuid')";
		if (mysqli_query($con, $sql2)) {
			$msg = array('msg'=>'success','ReturnCode' => 0,'Return'=>true);
		} else {//
			#echo "Error: " . $sql . "<br>" . mysqli_error($con);
			
		}
	mysqli_free_result($result);
}
}
echo json_encode($msg);
mysqli_close($con);
?>