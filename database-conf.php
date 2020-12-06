<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "health_insider";
$port = 3300;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection Failed :" . $conn->connect_error);
}
