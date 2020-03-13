<?php
require_once("../../dbConnect.php");
require_once("../../set-log-login.php");
session_start();
$nameframe = $_POST['nameframe'];
$optradio = $_POST['optradio'];
$optradio2 = $_POST['optradio2'];

if($optradio2 == "other"){
	$optradio2 = rtrim($_POST['other']);
}else{
	$optradio2 = $optradio2."-".rtrim($_POST['other']);
}
$message = $optradio."\n".'เจ้าของสวนปาล์ม : '.$nameframe."\n"."ข้อความ : ".$optradio2;
if($nameframe<>"" || $optradio <> "") {
	sendlinemesg();
	header('Content-Type: text/html; charset=utf-8');
	$res = notify_message($message);
	echo "<script>window.location='Chat.php'</script>";
} 
function sendlinemesg() {
    define('LINE_API',"https://notify-api.line.me/api/notify");
	define('LINE_TOKEN','o0PylK2S0ZURI3uGhgiC4geOUdP6jkhqjdSUxW9KxSz');
	function notify_message($message){

		$queryData = array('message' => $message);
		$queryData = http_build_query($queryData,'','&');
		$headerOptions = array(
			'http'=>array(
				'method'=>'POST',
				'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
						."Authorization: Bearer ".LINE_TOKEN."\r\n"
						."Content-Length: ".strlen($queryData)."\r\n",
				'content' => $queryData
			)
		);
		$context = stream_context_create($headerOptions);
		$result = file_get_contents(LINE_API,FALSE,$context);
		$res = json_decode($result);
		return $res;
	}
}
?>
