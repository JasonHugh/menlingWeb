var Realtime = AV.Realtime
	,TextMessage = AV.TextMessage
	,realtime = new Realtime({
	  appId: 'nfxWSOjzkw6t3KMkBVsc5LMJ-gzGzoHsz',
	  region: 'cn', //美国节点为 "us"
	});
//创建对话
function createConv() {
	realtime.createIMClient(visitor).then(function(v) {
		return v.createConversation({
	        "name": visitor+" & "+home_user,
	        "members": [
	        	home_user
	        ]
	    });
	}).then(function(conversation) {
		sessionStorage.conv_id = conversation.id;
		window.conversation = conversation
		getPastMessage(conversation)
	})
}
//根据ID获取对话
function getConvById(){
	realtime.createIMClient(visitor).then(function(v) {
		v.getConversation(sessionStorage.conv_id).then(function(conversation) {
		  	window.conversation = conversation
			getPastMessage(conversation)
		}).catch(console.error.bind(console));
	})
}

//发送消息
function sendMessage(message) {
	window.conversation.send(new AV.TextMessage(JSON.stringify({text:message,from:visitor})))
		.then(function(message) {

		}).catch(console.error);
}

//接收消息
function receiveMessage(){
	realtime.createIMClient(visitor).then(function(v) {
		v.on('message', function(message, conversation) {
			var content = $(".content");
			message = JSON.parse(message.text);
			content.append("<div class='textBoxOuter'><div class='textBox receive'>"+message.text+"</div><div class='clear'></div>");
			var scrollTo = content[0].scrollHeight;
			content.scrollTop(scrollTo);
		});
	}).catch(console.error);
}

//获取过去的消息
function getPastMessage(conversation){
	//收取之前的聊天记录
	var content = $('.content');
	conversation.queryMessages({
	  	limit: 10, // limit 取值范围 1~1000，默认 20
	}).then(function(messages) {
		for (var i = 0, max = messages.length; i < max; i++) {
			var message = JSON.parse(messages[i].text);
			if (message.from === home_user) {
				content.append("<div class='textBoxOuter'><div class='textBox receive'>"+message.text+"</div><div class='clear'></div>");
			}else{
				content.append("<div class='textBoxOuter'><div class='textBox send'>"+message.text+"</div><div class='clear'></div>");
			}
			var scrollTo = content[0].scrollHeight;
			content.scrollTop(scrollTo);
		}
		
	}).catch(console.error.bind(console));
}


function testSend(){
	realtime.createIMClient(home_user).then(function(v) {
		return v.createConversation({
			members: [visitor],
			name: home_user+" & "+visitor,
		});
	}).then(function(conversation) {
		return conversation.send(new AV.TextMessage(JSON.stringify({text:"你好",from:visitor})));
	}).then(function(message) {

	}).catch(console.error);
}