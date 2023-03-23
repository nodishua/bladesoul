<?php
session_start(); 
if(empty($_SESSION['uid'])){
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Sword Spirit Revolution background</title>
<link href="https://cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.staticfile.org/bootstrap-select/1.13.10/css/bootstrap-select.min.css" rel="stylesheet">
<link href="src/main.css" rel="stylesheet">
<script type="text/javascript" src="https://cdn.staticfile.org/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/bootstrap-select/1.13.10/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/bootstrap-select/1.13.10/js/i18n/defaults-zh_CN.js"></script>
</head>
<body>
<div class="intro" style="margin-top:0px;">
    <div class="col-md-3 col-centered tac">Sword Spirit Revolution user self -service system</div>
    <div class="container">
      <div class="row">
		<p class="col-centered tac text-danger"><?php $lv=$_SESSION['level']; if($lv==0){echo 'general user';}else if($lv==1){echo 'VIP';}else if($lv==2){echo 'Supreme VIP';}?></p>
        <div class="col-md-3 col-sm-8 col-centered">
          <form method="post" id="register-form" autocomplete="off" action="#" class="nice-validator n-default" novalidate>
            <div class="form-group">
				<input type="text" class="form-control" id="uid" name="uid" value="<?php echo $_SESSION['uid'];?>" placeholder="Please enter the role UID" autocomplete="off" readonly>
            </div>
			<div class="form-group">
			<select id='chargeid' class="form-control"><option value='0'>Please select the level of recharge</option>
				<option value="0">No recharge</option>
            </select>
            </div>
			
            <div class="form-group">
			<div class="input-group">
            <input type='text' class="form-control" value='' id='searchipt' placeholder='Object search'>
			<span class="input-group-btn"><button class="btn btn-info" type="button" id='search' >search</button></span>	
			</div>
            </div>
			<div class="form-group">
			<select id='mailid' class="form-control"><option value='0'>Please select the item you need to send</option>
            <?php
            $file = fopen("itemU.txt", "r");
            while(!feof($file)){
                $line=fgets($file);
		        $txts=explode(',',$line);
		        if(count($txts)==2){
		            echo '<option value="'.$txts[0].'">'.$txts[1].'</option>';
		        }
            }
            fclose($file);
            ?>
            </select>
            </div>
            <div class="form-group" id = "shu" >
              <input type="text" class="form-control" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" id="num" name="num" placeholder="Please enter the quantity" autocomplete="off">
            </div>
            <div class="form-center-button">
			  <input class="btn btn-danger" name='reg' id="1" value="Recharge" type="button" onclick= "charge()">
			  <input class="btn btn-danger" name='reg' id="1" value="Email" type="button" onclick= "mail()">
			</div>
			<br/>
			<div class="form-center-button">
				<input class="btn btn-danger" name='qk' id="1" value="Empty mail" type="button" onclick= "delmail()">
			</div>
			<br/>
            <div id="divMsg" style="color:#F00" class="validator-tips">Sword Spirit Revolution background</div>
          </form>
        </div>
      </div>
    </div>
  </div>
<script src='http://libs.baidu.com/jquery/1.7.2/jquery.min.js'></script>
<script>
$('#search').click(function(){
	  var keyword=$('#searchipt').val();
	  $.ajax({
		  url:'itemqueryUser.php',
		  type:'post',
		  'data':{keyword:keyword},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  if(data){
				  $('#mailid').html('');
				for (var i in data){
				  $('#mailid').append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
				}
			  }else{
				  $('#mailid').html('<option value="0">not found</option>');
			  }
		  },
		  error:function(){
			  bootbox.alert({message:'operation failed',title:"hint"});
		  }
	  });
  });
function mail(){
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("api.php", {
		uid:$("#uid").val(),
		item:$("#mailid").val(),
		num:$("#num").val(),
		'type':'mail'
	},function(data){ 
            bootbox.alert({message:data,title:"hint"});
	});
}
function delmail(){
	var msg = "Are you really sure to delete it?\ n \ n Please confirm！"; 
	if (confirm(msg)==true){ 
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("api.php", {
		uid:$("#uid").val(),
		'type':'delmail'
	},function(data){ 
            bootbox.alert({message:data,title:"hint"});
	});
	}
}
function charge(){
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("api.php", {
		uid:$("#uid").val(),
		chargeid:$("#chargeid").val(),
		num:$("#num").val(),
		'type':'charge'
	},function(data){ 
            bootbox.alert({message:data,title:"hint"});
	});
}

function test(obj){  
    var _status = obj.id;  
    if(_status != '1' || _status == undefined){  
         $('input[name=reg]').attr('id','0'); 		 
         $('input[name=reg]').attr('value','is submitting...');return false;  
    }else{  
         $('input[name=reg]').attr('id','0');  
         posts();   
    }    
} 
</script>
</body>
</html>