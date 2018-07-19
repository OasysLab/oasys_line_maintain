<?php

require "vendor/autoload.php";
header('Access-Control-Allow-Origin: *');
if (isset($_GET['stationid'])) {
	$stationid = $_GET['stationid'];
	$modeold = $_GET['modeold'];
	$modenew = $_GET['modenew'];
	$data = "Station : ".$stationid." Change Mode From ".$modeold." To ".$modenew;
	echo $data;
	$access_token = '1xRbg9ZC/ZDa9yTUfcsnca6+776kRaRV1SYOHEHLVsAdGVroKwefKlR48C1O/hVTYQtcDqujTEyK8McaiqaoudaL2BsAUxbf91jJkxnyrTYlDTB8hSBtAMm/uASSo6WDt9KbKjPl0ZbI9fpU6mNqMgdB04t89/1O/w1cDnyilFU=';
	$channelSecret = '11c8e5f96b7d59d300b100092b5834d3';

	$pushID = ['U1b6de0ae915180340652adccba3e084f','U20b47d150d50b896bbbf53bddbfa601a'];

	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($data);
		
	$file = fopen("vardump.txt", "r");
	$members = array();
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
$sql = "SELECT userid FROM user WHERE status=1";
$result = $conn->query($sql);
$userformdb;
if ($result->num_rows > 0) {
    // output data of each row
	$i = 0;
    while($row = $result->fetch_assoc()) {
		echo "id: " . $row["userid"];
		$userformdb[$i] = $row["userid"];
		$i = $i+1;
	}
} else {
    echo "0 results";
}
	while (!feof($file)) {
	   $members[] = fgets($file);
	}

	fclose($file);
	$userid = $userformdb;
	for($i=0;$i<count($userid);$i++){
		$response = $bot->pushMessage($userid[$i], $textMessageBuilder);
	}
	echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}






