<?php
include('DBfunctions.php');

$dbFunctions = new DBFunctions();
$response = array();

if (isset($_POST['action']) && $_POST['action'] != '') {

	
	$action = $_POST['action'];
	
	if ($action == 'join') {
		$username_ = $_POST['username'];
		$result = $dbFunctions->isUserExists($username_);
		//Check if user exist
		if ($result == true) {
			//If user exist, Check if user expired
			$result = $dbFunctions->isUserExpired($username_);
			if ($result == true) {
				//If user expired, delete user entry
				$result = $dbFunctions->deleteUser($username_);
				if ($result == true) {
					//If delete is successful, add username as a new entry
					$result = $dbFunctions->addUser($username_);
					if ($result == true) {
						$response["success"] = true;
						$response["uid"] = $result["uid"];
						$response["username"] = $result["username"];
						echo json_encode($response);
					}
					else {
						$response["success"] = false;
						$response["errorMsg"] = "Failed to create username. Please try again.";
						echo json_encode($response);			
					}
					
				}
				else {
					//Username could not be deleted
					$response["success"] = false;
					$response["errorMsg"] = "Failed to create username. Please try again.";
					echo json_encode($response);
				}
			}
			else {
				//User is still being used
				$response["success"] = false;
				$response["errorMsg"] = "Username is currently being use.";
				echo json_encode($response);			
			}
		}
		//Else user doest not exists, create user
		else {
			$result = $dbFunctions->addUser($username_);
			if ($result == true) {
				$response["success"] = true;
				$response["uid"] = $result["uid"];
				$response["username"] = $result["username"];
				echo json_encode($response);
			}
			else {
				$response["success"] = false;
				$response["errorMsg"] = "Failed to create username. Please try again.";
				echo json_encode($response);
			}
		}	
	}
	else if ($action == 'setSession') {
		//Set session values
		session_start();
		$uid_ = $_POST['uid'];
		$username_ = $_POST['username'];
	
		$_SESSION["uid"] = $uid_;
		$_SESSION["username"] = $username_;
	}
	else if ($action == "getSession") {
		//Get the session values
		session_start();
		if(isset($_SESSION["username"])) {
			$response["success"] = true;
			$response["uid"] = $_SESSION["uid"];
			$response["username"] = $_SESSION["username"];	
			echo json_encode($response);
		}
		else {
			$response["success"] = false;
			$response["errorMsg"] = "Session not set";
			echo json_encode($response);
		}
	}
	else if ($action == "verifySession") {
		$uid_ = $_POST['uid'];
		$username_ = $_POST['username'];
		
		//Check if uid and username stored in session is still in the database
		$result = $dbFunctions->isSessionExists($uid_, $username_);
		if ($result == true) {
			//If session is still in database, check if it has expired
			$result = $dbFunctions->isSessionExpired($uid_, $username_);
			if ($result == true) {
				//Session has expired
				//Delete username from the database
				$dbFunctions->deleteUser($username_);
				$response["success"] = false;
				$response["errorMsg"] = "Your session has expired, and you have been logged out.";
				echo json_encode($response);
			}
			else {
				//Session has not expired
				$response["success"] = true;
				echo json_encode($response);
			}		
			
		}
		else {
			$response["success"] = false;
			$response["errorMsg"] = "Your session has expired, and you have been logged out.";
			echo json_encode($response);
		}
			
				
		//If session is still in database
		//echo "uid: " . $uid_ . " username: " . $username_;
	}
	else if ($action == "deleteSession") {
		//Delete Session
		session_start();
		session_unset();
		session_destroy(); 
	}
	else if ($action == "exitChat") {
		session_start();
		if(isset($_SESSION["username"])){
			$username_ = $_SESSION["username"];
			
			$file = fopen("../chatLog.txt", "a");
			fwrite($file,"<div class='msgContainer'> <i>User ". $username_ ." has left the chat.</i><br> </div>" .PHP_EOL);
			fclose($file);
			
			//Delete user from the database
			$dbFunctions->deleteUser($username_);
		}		
		//Destroy session
		session_unset();
		session_destroy(); 
	}
	else if ($action == "post") {
		session_start();
		if(isset($_SESSION["username"])){
			$username_ = $_SESSION["username"];
			$chatText_ = $_POST['message'];
			date_default_timezone_set('America/Los_Angeles');
		
			$file = fopen("../chatLog.txt", "a");
			fwrite($file,"<div class='msgContainer'>(".date("g:i A").") <h4 id='username'>".$username_.":</h4> ".stripslashes(htmlspecialchars($chatText_))."<br></div>" .PHP_EOL);
			fclose($file);
			
			$dbFunctions->updateActivity($username_);
			
		}
	}
	else if ($action == "idle") {
		//Delete session
		session_start();
		if(isset($_SESSION["username"])){
			$username_ = $_SESSION["username"];
			
			$file = fopen("../chatLog.txt", "a");
			fwrite($file,"<div class='msgContainer'> <i>User ". $username_ ." has left the chat.</i><br> </div>" .PHP_EOL);
			fclose($file);
			
			//Delete user from the database
			$dbFunctions->deleteUser($username_);
		}		
		//Destroy session
		session_unset();
		session_destroy(); 

		$response["errorMsg"] = "You have been kicked out for inactivity.";
		echo json_encode($response);
	}
	else {
		$response["success"] = false;
		$response["errorMsg"] = "Invalid action.";
		echo json_encode($response);
	}
}
else {
	$response["success"] = false;
	$response["errorMsg"] = "Missing action property.";
	echo json_encode($response);	
}
?>