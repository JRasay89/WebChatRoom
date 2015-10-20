<?php
$user_ = $_POST['username'];

$servername_ = "localhost";
$username_ = "webChat";
$password_ = "password";
$dbName_ = "webChatDB";

// Create connection
$conn_ = new mysqli($servername_, $username_, $password_, $dbName_);

checkUser($user_, $conn_);


function checkUser($user, $conn) {
	$sql = "SELECT username FROM Users WHERE username = '$user'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	$response;
	if ($num_rows > 0) {
		$response["exists"] = true;
		echo json_encode($response);
	}
	else {
		$response["exists"] = false;
		echo json_encode($response);
	}
}
?>