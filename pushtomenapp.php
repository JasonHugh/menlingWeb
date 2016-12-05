<?php
    ob_start();
    session_start();
	$id = $_GET['id'];
    $customer = $_GET["customer"];
    $home_user = $_GET["home_user"];
    $alert = $customer.' 正在敲门';
    $action = 'com.menapp.bell_alert';

    //只推送一次
    if (isset($_SESSION['visitor']) && isset($_SESSION['conv_id']) && isset($_COOKIE['expire'])) {
        $visitor = $_SESSION['visitor'];
        $conv_id = $_SESSION['conv_id'];
    }else{
        $visitor = 'visitor'.time();
        $_SESSION['visitor'] = $visitor;
        //先创建一个对话,获取对话ID
        $post_data = array(
          'name' => $visitor." & ".$home_user,
          'm' => array($visitor,$home_user)
        );
        $data = json_encode($post_data);
        $url = 'https://api.leancloud.cn/1.1/classes/_Conversation';
        list($return_code, $return_content) = http_post_data($url, $data);
        //var_dump($return_content);
        $json = json_decode($return_content);
        $conv_id = $json->objectId;
        $_SESSION['conv_id'] = $conv_id;

        //推送消息给房主
        $post_data = array(
          'data' => array('conv_id'=>$conv_id,'visitor'=>$visitor,'customer'=>$customer,'alert'=>$alert,'action'=>$action),
          'channels' => '',
          'where' => array('installationId'=>$id)
        );
        $data = json_encode($post_data);
        $url = 'https://api.leancloud.cn/1.1/push';
        list($return_code, $return_content) = http_post_data($url, $data);
        //var_dump($return_content);
        //保存cookie，防止重复提醒
        setcookie("expire",'3600', time()+3600*1);
    }
    if (!isset($visitor) or !isset($conv_id)){
        $fail = true;
    }


	function http_post_data($url, $data_string) {  
  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        	"X-LC-Id: nfxWSOjzkw6t3KMkBVsc5LMJ-gzGzoHsz",
	    	"X-LC-Key: rtMwao5t0tbBMMgFgqqnjkiS",
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
    <title>简单门铃</title>
</head>
<body>
    <?php if (isset($fail)) { ?>
        <h3 style="text-align: center">门铃暂未启用</h3>
    <?php }else{ ?>
    <h3 style="text-align: center">简单门铃已为您通知房主开门<br/><br/>请稍等...<br/><br/>
    <a href='chat.php?id=<?=$id?>&home_user=<?=$home_user?>'>点击此处和房主对话</a></h3>
    <script type="text/javascript">
        sessionStorage.visitor = "<?=$visitor?>";
        sessionStorage.conv_id = "<?=$conv_id?>";
    </script>
    <?php } ?>
</body>
</html>
