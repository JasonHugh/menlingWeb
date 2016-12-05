<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
	<title>简单门铃</title>
	<style type="text/css">
		body,h3{margin: 0;padding: 0;text-align: center}
		.textBoxOuter{width: 100%}
		.main{}
		.footer{display:-webkit-flex;width:100%;height: 60px;background-color:#fff;position: fixed;bottom: 0;text-align: left}
		.header{width:100%;height: 50px;background-color:#336699;line-height: 50px}
		.header h3{color: #fff}
		.content{height:100%;width:100%;background-color: #ddd;overflow-y:scroll;}
  		.sendBox{flex:1;height: 40px;margin: 10px 10px;padding:0 10px;font-size: 15px;border: 1px solid #0cf}
  		.sendBtn{height:40px;margin-top:10px;margin-right:10px;width:80px;border-radius: 8px;background-color: #0f0;color:#fff;border: 1px solid #0cf}
  		.sendBtn:active{opacity: 0.5}
  		.textBox{font-size: 16px;border-radius: 20px;margin: 10px 0 5px 0;padding:10px 15px;max-width: 300px;word-wrap:break-word;word-break:break-all;text-align:left;display: inline-block;}
  		.alert{float:center;background-color:#0cf;color: #444;padding:5px 20px;font-size: 13px;border-radius: 15px}
  		.send{float:right;margin-left:50px;background-color:#0f0;color:#000}
  		.receive{float:left;margin-right:50px;background-color:#fff;color: #000}
  		.clear{clear: both;}
	</style>
</head>
<body>
	<div class="main">
		<div class="header"><h3>和房主对话</h3></div>
		<div class="content">
			<div class="textBox alert">已通知房主开门</div>
		</div>
		<div class="footer">
			<input type="text" class="sendBox" placeholder="请输入想对房主说的话">
			<button class="sendBtn">发送</button>
		</div>
	</div>
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="./js/node_modules/leancloud-realtime/dist/realtime.browser.js"></script>
	<script type="text/javascript" src="./js/leancloudapi.js"></script>
	<script type="text/javascript">
		var height = $(window).height();
		$(".content").height((parseInt(height)-110)+'px');
		//消息框滚动到最底部
		var content = $(".content")
		var scrollTo = content[0].scrollHeight;
		content.scrollTop(scrollTo);

		var visitor
			,conv_id
			,home_user = "<?=$_GET['home_user']?>";
		//判断visitor是否已生成
		sessionStorage.visitor = "<?=$_SESSION['visitor']?>";
        sessionStorage.conv_id = "<?=$_SESSION['conv_id']?>";
		if (!sessionStorage.visitor || !sessionStorage.conv_id) {
			alert("会话已过期，请重新扫码");
			exit();
		}
		visitor = sessionStorage.visitor;
		//根据ID获取一个对话
		getConvById()
		
		//testSend()
		//setInterval(testSend,1000);
		//接收消息
		receiveMessage();
		//发送消息
		$(".sendBtn").click(function(){
			var message = $(".sendBox").val();
			var content = $(".content")
			if ($.trim(message) != "") {
				content.append("<div class='textBoxOuter'><div class='textBox send'>"+$.trim(message)+"</div><div class='clear'></div>");
				sendMessage($.trim(message));
				$(".sendBox").val("");
				var scrollTo = content[0].scrollHeight;
				content.scrollTop(scrollTo);
			}
		})
	</script>
</body>
</html>