<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
	<title>简单门铃</title>
	<style type="text/css">
		body,h3{margin: 0;padding: 0;text-align: center}
		div{display: -webkit-flex;display: flex;}
		.main{flex:1;flex-direction:column;}
		.footer{height: 60px;flex-direction:row;background-color:#fff;align-items:center;}
		.header{height: 50px;background-color:#336699;justify-content: center;align-items:center;}
		.header h3{color: #fff}
		.content{flex:1;background-color: #ddd;flex-direction:column;}
  		.sendBox{flex:1;height: 40px;margin: 0 10px;padding:0 10px;font-size: 15px;border: 1PX solid #0cf}
  		.sendBtn{height:40px;margin-right:10px;padding:0 20px;border-radius: 8px;background-color: #0f0;color:#fff;border: 1px solid #0cf}
  		.sendBtn:active{opacity: 0.5}
  		.textBox{font-size: 16px;border-radius: 20px;margin: 10px 0 5px 0;padding:10px 15px;max-width: 300px;word-wrap:break-word;word-break:break-all;text-align:left;}
  		.alert{align-self: center;background-color:#0cf;color: #444;padding:5px 20px;font-size: 13px;border-radius: 15px}
  		.send{align-self: flex-end;margin-left:50px;background-color:#0f0;color:#000}
  		.receive{align-self: flex-start;margin-right:50px;background-color:#fff;color: #000}
	</style>
</head>
<body>
	<div class="main">
		<div class="header"><h3>和房主对话</h3></div>
		<div class="content">
			<div class="textBox alert">已通知房主开门</div>
			<div class="textBox send">你的快递到了</div>
			<div class="textBox receive">好的，稍等一下</div>
		</div>
		<div class="footer">
			<input type="text" class="sendBox" placeholder="请输入想对房主说的话">
			<button class="sendBtn">发送</button>
		</div>
	</div>
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="./conf.js"></script>
	<script src="./node_modules/leancloud-realtime/dist/realtime.browser.js"></script>
	<script type="text/javascript" src="./js/leancloudapi.js"></script>
	<script type="text/javascript">
		var height = $(window).height();
		$(".main").css("height",height);

		//createConv();
		$(".sendBtn").click(function(){
			var message = $(".sendBox").val();
			if ($.trim(message) != "") {
				$(".content").append("<div class='textBox send'>"+$.trim(message)+"</div>");
				sendMessage($.trim(message));
			}
		})
	</script>
</body>
</html>