<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>GM Panel LouLx</title>
<link href="https://cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.staticfile.org/bootstrap-select/1.13.10/css/bootstrap-select.min.css" rel="stylesheet">
<link href="src/main.css" rel="stylesheet">
<script type="text/javascript" src="https://cdn.staticfile.org/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/bootstrap-select/1.13.10/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/bootstrap-select/1.13.10/js/i18n/defaults-zh_CN.js"></script>
</head>
  <div class="intro" style="margin-top:0px;">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-8 col-centered">
			<form method="post" id="register-form" autocomplete="off" action="#" class="nice-validator n-default" novalidate>
				<div class="form-group">
					<input type="text" class="form-control" id="uid" name="uid" value='' placeholder="Nhập tên tài khoản" autocomplete="off">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="pwd" name="pwd" value='' placeholder="Nhập mật khẩu tài khoản" autocomplete="off">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="gmcode" name="gmcode" placeholder="Nhập mật khẩu ủy quyền" autocomplete="off">
				</div>
				<div class="form-center-button">
				  <input class="btn btn-danger" name='reg' id="1" value="Đăng Nhập" type="button" onclick= "login()">
				</div>
			</form>
		</div>
      </div>
    </div>
  </div>
</body>
<script src='http://libs.baidu.com/jquery/1.7.2/jquery.min.js'></script>
<script>
function login(){
	$.ajax({
		  url:'api.php',
		  type:'post',
		  'data':{type:'login',uid:$("#uid").val(),pwd:$("#pwd").val(),gmcode:$("#gmcode").val(),},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  if(data.code==200){
				  alert(data.msg);
				  window.location = "./user.php";
			  }else{
				  alert(data.msg);
			  }

		  },
		  error:function(){
			  alert('Đăng nhập thất bại');
		  }
	  });

}
function test(obj){  
    var _status = obj.id;  
    if(_status != '1' || _status == undefined){  
         $('input[name=reg]').attr('id','0'); 		 
         $('input[name=reg]').attr('value','đang nộp...');return false;  
    }else{  
         $('input[name=reg]').attr('id','0');  
         posts();   
    }    
} 
</script>
</body>
</html>