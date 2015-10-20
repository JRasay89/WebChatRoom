<?php
$user_ = $_POST['username'];

$servername_ = "localhost";
$username_ = "webChat";
$password_ = "password";
$dbName_ = "webChatDB";

// Create connection
$conn_ = new mysqli($servername_, $username_, $password_, $dbName_);

checkUserExpired($user_, $conn_);


function checkUserExpired($user, $conn) {
	$sql = "SELECT username FROM Users WHERE last_activity < (NOW() - INTERVAL 10 MINUTE) and username = '$user'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	$response;
	if ($num_rows > 0) {
		$response["expired"] = true;
		echo json_encode($response);
	}
	else {
		$response["expired"] = false;
		echo json_encode($response);
	}
}
?>