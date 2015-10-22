<?php
	session_start();
	$response;
	if(isset($_SESSION["username"])){
		$response["isset"] = true;
		$response["uid"] = $_SESSION["uid"];
		$response["username"] = $_SESSION["username"];
		echo json_encode($response);
	}
	else {
		$response["isset"] = false;
		echo json_encode($response);
	}
?>