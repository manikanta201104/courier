<?php
$conn = mysqli_connect("localhost", "root", "Honeykanna2024@", "courierdb");
if ($conn) {
    echo "Connected to database successfully!";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}
?>