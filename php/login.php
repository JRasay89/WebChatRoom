<?php

$user_ = $_POST['username'];

$servername_ = "localhost";
$username_ = "webChat";
$password_ = "password";
$dbName_ = "webChatDB";

// Create connection
$conn_ = new mysqli($servername_, $username_, $password_, $dbName_);

login($user_, $conn_);

function login($user, $conn) {
	//Insert username to database
	$sql = "INSERT INTO Users (username) VALUES ('$user')";
	$response;
	if ($conn->query($sql) === true) {
		$response["success"] = true;
		echo json_encode($response);	
	} else {
		$response["success"] = false;
		echo json_encode($response);
	}
}

?>