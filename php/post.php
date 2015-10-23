<?php
	$servername_ = "localhost";
	$username_ = "webChat";
	$password_ = "password";
	$dbName_ = "webChatDB";

	// Create connection
	$conn_ = new mysqli($servername_, $username_, $password_, $dbName_);
	
	
	session_start();
	if(isset($_SESSION["username"])){
		$user_ = $_SESSION["username"];
		$chatText = $_POST['message'];
		date_default_timezone_set('America/Los_Angeles');
		
		$file = fopen("../chatLog.txt", "a");
		fwrite($file,"<div class='msgContainer'>(".date("g:i A").") <h4 id='username'>".$user_.":</h4> ".stripslashes(htmlspecialchars($chatText))."<br></div>" .PHP_EOL);
		fclose($file);
		
		//Update last activity of user
		$sql = "UPDATE Users SET last_activity = now() WHERE username = '$user_'";
		$conn_->query($sql);
	}
?>