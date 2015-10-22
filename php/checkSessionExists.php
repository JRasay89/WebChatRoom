<?php

$uid_ = $_POST['userID'];
$user_ = $_POST['username'];


$servername_ = "localhost";
$username_ = "webChat";
$password_ = "password";
$dbName_ = "webChatDB";

// Create connection
$conn_ = new mysqli($servername_, $username_, $password_, $dbName_);

checkSessionExists($uid_, $user_, $conn_);


function checkSessionExists($uid, $user, $conn) {
	$sql = "SELECT username FROM Users WHERE id = $uid and username = '$user'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	$response;
	if ($num_rows > 0) {
		$response["success"] = true;
		echo json_encode($response);
	}
	else {
		$response["success"] = false;
		echo json_encode($response);
	}
}
?>