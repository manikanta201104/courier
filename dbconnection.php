<?php
$host = "localhost";
$username = "root";
$password = "Honeykanna2024@";
$dbname = "courierdb";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>