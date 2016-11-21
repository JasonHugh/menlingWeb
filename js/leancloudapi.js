var now = new Date().getTime();
var conv_id;
//创建对话
function createConv() {
	$.ajax({
		headers: {
        	"Accept": "application/json; charset=utf-8",
	  	  	"Content-Type": "application/json",
        	"X-LC-Id": conf.LeanCloudId,
        	"X-LC-Key": conf.LeanCloudKey
    	},
		url:"https://api.leancloud.cn/1.1/classes/_Conversation",
		type:"post",
		dataType:"json",
		data:JSON.stringify({
	        "name": now+"room",
	        "m": [
	          now+"", "hay123456"
	        ]
	    }),
	    success:function(data){
	    	conv_id = data.objectId
	    }
	})
}

//发送消息
function sendMessage(message) {
	$.ajax({
		headers: {
        	"Accept": "application/json; charset=utf-8",
	  	  	"Content-Type": "application/json",
        	"X-LC-Id": conf.LeanCloudId,
        	"X-LC-Key": conf.LeanCloudKey
    	},
		url:"https://leancloud.cn/1.1/rtm/messages",
		type:"post",
		dataType:"json",
		data:JSON.stringify({
	        "from_peer": "1478765415080",
	        "conv_id": "58242b6967f3560058c477a6",
	        "transient": false,
	        "message": {_lctype:-1,_lctext:"这是一个纯文本消息"},
	        "no_sync": true
	    }),
	    success:function(data){
	    	alert(data)
	    }
	})
}