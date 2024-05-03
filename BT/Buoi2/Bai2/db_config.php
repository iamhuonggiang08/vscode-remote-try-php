<?php
// Database configuration
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "bai2buoi2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
