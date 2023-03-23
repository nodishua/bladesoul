<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>GM BnS M LouLx</title>
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
  <div class="col-md-3 col-centered tac">GM BnS M LouLx</div>
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-8 col-centered">
          <form method="post" id="register-form" autocomplete="off" action="#" class="nice-validator n-default" novalidate>
            <div class="form-group">
              <input type="password" class="form-control" id="sqm" name="sqm" value='' placeholder="Mã GM là admin" autocomplete="off">
            </div>
            <div class="form-group">
				<input type="text" class="form-control" id="uid" name="uid" placeholder="Nhập tên tài khoản" autocomplete="off">
            </div>
			  <div class="form-group">
			  <input class="btn btn-danger" name='reg' id="1" value="Tham gia VIP1" type="button" onclick= "addvip1()">
			  <input class="btn btn-danger" name='reg' id="1" value="Tham gia VIP2" type="button" onclick= "addvip2()">
			  </div>
			<div class="form-group">
			<select id='chargeid' class="form-control"><option value='0'>Chọn nạp tiền</option>
				<option value="0">Không nạp tiền</option>
            </div>
            <div class="form-group">
			<div class="input-group">
            <input type='text' class="form-control" value='' id='searchipt' placeholder='Tìm kiếm vật phẩm'>
			<span class="input-group-btn"><button class="btn btn-info" type="button" id='search' >Tìm kiếm</button></span>	
			</div>
            </div>
			<div class="form-group">
			<select id='mailid' class="form-control"><option value='0'>Chọn đạo cụ để gửi</option>
            <?php
            $file = fopen("item.txt", "r");
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
              <input type="text" class="form-control" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" id="num" name="num" placeholder="Nhập số lượng" autocomplete="off">
            </div>
            <div class="form-center-button">
			  <input class="btn btn-danger" name='reg' id="1" value="Nạp đá thần" type="button" onclick= "charge()">
			  <input class="btn btn-danger" name='reg' id="1" value="Gửi thư" type="button" onclick= "mail()">
			</div><br>
			<div class="form-center-button">
				<input class="btn btn-danger" name='qk' id="1" value="Thư trống" type="button" onclick= "delmail()">
			</div>
			<br/>
            <div id="divMsg" style="color:#F00" class="validator-tips">LouLx Game</div>
          </form>
        </div>
      </div>
    </div>
  </div>
<script>
$('#search').click(function(){
	  var keyword=$('#searchipt').val();
	  $.ajax({
		  url:'itemquery.php',
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
				  $('#mailid').html('<option value="0">Không tìm thấy</option>');
			  }
		  },
		  error:function(){
			  bootbox.alert({message:'lỗi hệ thống',title:"Gợi ý"});
		  }
	  });
  });

function mail(){
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("vip.php", {
		sqm:$("#sqm").val(),
		uid:$("#uid").val(),
		item:$("#mailid").val(),
		num:$("#num").val(),
		'type':'mail'
	},function(data){ 
            bootbox.alert({message:data,title:"Gợi ý"});
	});
}
function delmail(){
	var msg = "Bạn có chắc chắn muốn xóa? \n\nXin xác nhận!"; 
	if (confirm(msg)==true){ 
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("vip.php", {
		sqm:$("#sqm").val(),
		uid:$("#uid").val(),
		'type':'delmail'
	},function(data){ 
            bootbox.alert({message:data,title:"Gợi ý"});
	});
	}
}
function charge(){
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("vip.php", {
		sqm:$("#sqm").val(),
		uid:$("#uid").val(),
		chargeid:$("#chargeid").val(),
		num:$("#num").val(),
		'type':'charge'
	},function(data){ 
            bootbox.alert({message:data,title:"Gợi ý"});
	});
}
function addvip1(){
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("vip.php", {
		sqm:$("#sqm").val(),
		uid:$("#uid").val(),
		'type':'addvip1'
	},function(data){ 
            bootbox.alert({message:data,title:"Gợi ý"});
	});
}
function addvip2(){
	$.ajaxSetup({contentType: "application/x-www-form-urlencoded; charset=utf-8"});
	$.post("vip.php", {
		sqm:$("#sqm").val(),
		uid:$("#uid").val(),
		'type':'addvip2'
	},function(data){ 
            bootbox.alert({message:data,title:"Gợi ý"});
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