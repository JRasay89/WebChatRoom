<?php
	session_start();
	if(isset($_SESSION["username"])){
		$user_ = $_SESSION["username"];
		
		$file = fopen("../chatLog.txt", "a");
		fwrite($file,"<div class='msgContainer'> <i>User ". $user_ ." has left the chat.</i><br> </div>" .PHP_EOL);
		fclose($file);
	}
?>