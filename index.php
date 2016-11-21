<?php
	$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
	<title>简单门铃</title>
	<style type="text/css">
		body{margin: 0;padding: 0;text-align: center}
		div{display: -webkit-flex;display: flex;}
		.main{width: 100%;flex-direction: column;}
		.box{flex: 1;background:#0cf;flex-direction: row;}
		.sub_box{align-items: center;justify-content: center}
		.sub_box h3{color: #eee}
		.sub_box:active{opacity:0.5;}
		#shadow{display: none;height: 100%;width: 100%;opacity:0; position: absolute;left: 0;top: 0;z-index: 1;background-color: #000}
		.modalBox{display: none;position: absolute;left:50%;margin-left:-150px;margin-top:-50px;top:50%;width: 300px;height: 100px;background-color: #fff;z-index: 2}
		.modalBox input{height:40px;margin:30px 10px;padding:0 16px;font-size: 14px }
		.modalBox #send{height: 40px;width: 60px;margin:31px 0;border: 1px solid #0cf;border-radius: 10px; background-color: #009966;color: #fff}
		#send:active{opacity:0.5;}
	</style>
</head>
<body>
	<div class="main">
		<h1 style="background-color: #336699;font-size: 20px;color: #fff;margin:0;padding: 20px">欢迎来访！您的身份是：</h1>
		<div class="box">
			<div class="box sub_box" style="background:#009966"><h3>亲朋好友</h3></div>
			<div class="box sub_box"><h3>外卖快递</h3></div>
		</div>
		<div class="box">
			<div class="box sub_box"><h3>邻里街坊</h3></div>
			<div class="box sub_box" id='other' style="background:#009966"><h3>其他人</h3></div>
		</div>
	</div>
	<div class="modalBox">
		<input type="text" placeholder="请输入您的身份或姓名" />
		<button id="send">确定</button>
	</div>
	<div id="shadow"></div>
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
		var height = $(window).height();
		$(".main").css("height",height);
		$("div.sub_box:not(#other)").click(function(){
			location.href = "pushtomenapp.php?id=<?=$id?>&customer="+$(this).children("h3").text();
		})
		$("#other").click(function() {
			$("#shadow").show();
			$(".modalBox").show();
		})
		$("#shadow").click(function() {
			$("#shadow").hide();
			$(".modalBox").hide();
		})
		$("#send").click(function(){
			var name = $(".modalBox>input").val().trim();
			if (name !== "") {
				location.href = "pushtomenapp.php?id=<?=$id?>&customer="+name;
			}
		})
	</script>
</body>
</html>