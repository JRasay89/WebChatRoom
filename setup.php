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


//Create Database
$sql = "CREATE DATABASE webChatDB";
if ($conn->query($sql) === TRUE) {
	echo "Database created successfully";
}
else {
	echo "Error creating database: " . $conn->error;	
}

// sql to create table
$sql = "CREATE TABLE Users (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) UNIQUE NOT NULL,
last_activity TIMESTAMP Default now()
)";

/*
if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} 
else {
    echo "Error creating table: " . $conn->error;
}
*/


$conn->close();

?>