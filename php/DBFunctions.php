<?php
include('DBConnect.php');

class DBFunctions {
	private $dbConnect;

    // constructor
    function __construct() {
        // connecting to database
        $this->dbConnect = new DBConnect();
        $this->dbConnect->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
	
	function addUser($username) {
		$sql_query = "INSERT INTO Users (username) VALUES ('$username')";
		$result = $this->dbConnect->getConn()->query($sql_query);
		if ($result == true) {
			$result = array();
			$result["username"] = $username;
			$result["uid"] = $this->dbConnect->getConn()->insert_id;
			return $result;
		}
		else {
			return false;
		}
	}
	
	function deleteUser($username) {
		$sql_query = "DELETE FROM Users WHERE username = '$username'";
		$result = $this->dbConnect->getConn()->query($sql_query);
		if ($result == true) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function isUserExists($username) {
		$sql_query = "SELECT username FROM Users WHERE username = '$username'";
		$result = $this->dbConnect->getConn()->query($sql_query);
		$num_rows = $result->num_rows;
		if ($num_rows > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function isUserExpired($username) {
		$sql_query = "SELECT username FROM Users WHERE last_activity < (NOW() - INTERVAL 1 MINUTE) and username = '$username'";
		$result = $this->dbConnect->getConn()->query($sql_query);
		$num_rows = $result->num_rows;
		if ($num_rows > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function isSessionExists($uid, $username) {
		$sql_query = "SELECT username FROM Users WHERE id = $uid and username = '$username'";
		$result = $this->dbConnect->getConn()->query($sql_query);
		$num_rows = $result->num_rows;
		if ($num_rows > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function isSessionExpired($uid, $username) {
		$sql_query = "SELECT username FROM Users WHERE last_activity < (NOW() - INTERVAL 1 MINUTE) and id = $uid and username = '$username'";
		$result = $this->dbConnect->getConn()->query($sql_query);
		$num_rows = $result->num_rows;
		if ($num_rows > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function updateActivity($username) {
		$sql_query = "UPDATE Users SET last_activity = now() WHERE username = '$username'";
		$this->dbConnect->getConn()->query($sql_query);
	}
	
}
?>