<?php

$servername = "localhost";
$username = "webChat";
$password = "password";
$dbName = "webChatDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
//Create Database
$sql = "CREATE DATABASE webChatDB";
if ($conn->query($sql) === TRUE) {
	echo "Database created successfully";
}
else {
	echo "Error creating database: " . $conn->error;	
}
*/

/*
// sql to create table
$sql = "CREATE TABLE Users (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
last_activity TIMESTAMP Default now()
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} 
else {
    echo "Error creating table: " . $conn->error;
}
*/


/*
//Insert user
$user = "pikachu";
$sql = "INSERT INTO Users (username) VALUES ('$user')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
*/
/*
//Delete
$user = "pikachu";
$sql = "DELETE FROM Users WHERE last_activity < (NOW() - INTERVAL 1 MINUTE) and username = '$user'";
if ($conn->query($sql) === TRUE) {
    echo "Data deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
*/

$user = "pikachu";
$sql = "SELECT username FROM Users WHERE last_activity < (NOW() - INTERVAL 4 HOUR) and username = '$user'";
$result = $conn->query($sql);
$num_rows = $result->num_rows;
if ($num_rows > 0) {
	//return true;
	echo "User found";
}
else {
	echo "User not found";
}

$conn->close();

?>