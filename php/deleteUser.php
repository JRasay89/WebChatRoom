<?php
$user_ = $_POST['username'];

$servername_ = "localhost";
$username_ = "webChat";
$password_ = "password";
$dbName_ = "webChatDB";

// Create connection
$conn_ = new mysqli($servername_, $username_, $password_, $dbName_);

deleteUser($user_, $conn_);


function deleteUser($user, $conn) {
	$sql = "DELETE FROM Users WHERE username = '$user'";
	$result = $conn->query($sql);
	$response;
	if ($result) {
		$response["deleted"] = true;
		echo json_encode($response);
	}
	else {
		$response["deleted"] = false;
		echo json_encode($response);
	}
}
?>