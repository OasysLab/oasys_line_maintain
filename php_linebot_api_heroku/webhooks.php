<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = '1xRbg9ZC/ZDa9yTUfcsnca6+776kRaRV1SYOHEHLVsAdGVroKwefKlR48C1O/hVTYQtcDqujTEyK8McaiqaoudaL2BsAUxbf91jJkxnyrTYlDTB8hSBtAMm/uASSo6WDt9KbKjPl0ZbI9fpU6mNqMgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			//$text = $event['source']['userId'];
			$text = "เลือกคำสั่งที่เมนูด้านล่าง";
$servername = "14352ea7-f919-468c-9792-a7ee00f56295.mysql.sequelizer.com";
$username = "uvztmuqbiecydfhy";
$password = "5cVopczqmvb844238yTXSQTuQFWuirWbQUKsbVtVyMGhUPjysk8QBConrzFQnfg4";
$dbname = "db14352ea7f919468c9792a7ee00f56295";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($event['message']['text']=="รับแจ้งเตือน"){
$text = "รับแจ้งเตือนแล้วครับ";
$sql = "INSERT IGNORE INTO user (userid, status) VALUES ('".$event['source']['userId']."', 1)";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();


			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
