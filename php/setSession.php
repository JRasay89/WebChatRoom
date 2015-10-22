<?php
	session_start();
	
	$uid_ = $_POST['userID'];
	$user_ = $_POST['username'];
	
	$_SESSION["uid"] = $uid_;
	$_SESSION["username"] = $user_;
?>