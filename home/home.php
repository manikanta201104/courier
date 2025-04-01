<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: ../index.php');
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {

            background-repeat: no-repeat;
            background-size: cover;
            margin: 0; 
            padding: 0; 
            font-family: 'Times New Roman', Times, serif;
        }
        .container {
            text-align: center;
            font-weight: bold;
            padding-top: 100px; 
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h2>This is IIITV-ICD Courier Management Service</h2>
        <h4>The fastest courier service in India</h4>

    </div>
</body>
</html>
