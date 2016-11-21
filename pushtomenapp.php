<?php
	$id = $_GET['id'];
    $customer = $_GET["customer"];
	$post_data = array(
	  'data' => array('customer'=>$customer,'alert'=>$customer.' 正在敲门','action'=>'com.menapp.bell_alert'),
	  'channels' => '',
	  'where' => array('installationId'=>$id)
	);
	$data = json_encode($post_data);
	$url = 'https://api.leancloud.cn/1.1/push';
	//list($return_code, $return_content) = http_post_data($url, $data);
	//var_dump($return_content);

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
    <h3 style="text-align: center">简单门铃已为您通知房主开门<br/><br/>请稍等...</h3>
</body>
</html>