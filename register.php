<?php
require_once "dbconnection.php"; // This should set $conn
require_once "session.php";

// Check if the connection is established
if (!isset($conn)) {
    die("Database connection failed. Please check dbconnection.php.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fullname = $_POST['name'];
    $phn = $_POST['ph'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email already exists using a prepared statement
    $check_query = "SELECT * FROM `users` WHERE `email` = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    if ($stmt === false) {
        die("Prepare failed: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email already taken. Please choose a different email.');</script>";
    } else {
        // Proceed with registration
        if ($password === $confirm_password) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the `login` table
            $qry2 = "INSERT INTO `login` (`email`, `password`) VALUES (?, ?)";
            $stmt2 = mysqli_prepare($conn, $qry2);
            if ($stmt2 === false) {
                die("Prepare failed: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt2, "ss", $email, $hashed_password);
            $run2 = mysqli_stmt_execute($stmt2);

            // Insert into the `users` table
            $qry = "INSERT INTO `users` (`email`, `name`, `pnumber`) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $qry);
            if ($stmt === false) {
                die("Prepare failed: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "sss", $email, $fullname, $phn);
            $run = mysqli_stmt_execute($stmt);

            if ($run && $run2) {
                // Get the last inserted ID from the `login` table
                $last_id = mysqli_insert_id($conn);
                session_start();
                $_SESSION['uid'] = $last_id;
                $_SESSION['email'] = $email;
                echo "<script>alert('Registration Successful :)'); window.location='index.php';</script>";
                exit;
            } else {
                echo "<script>alert('Registration failed. Please try again later.'); </script>";
            }

            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt2);
        } else {
            echo "<script>alert('Password mismatched!!');</script>";
        }
    }
    mysqli_stmt_close($stmt);
}

// Close the database connection (optional, as PHP will close it automatically)
// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/brr.png');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body><br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 style="color:green">Register</h2>
            <p>Please fill this form to create an account.</p>
            <form action="" method="post">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone Num.</label>
                    <input type="text" name="ph" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-danger" value="Register">
                </div>
                <p>Already have an account? <a href="index.php" style="color: red;">Login here</a>.</p>
            </form>
        </div>
    </div>
    <hr>
    <p>Notice: If the email ID is registered before, it will not respond.</p>
    <p>In this case, reset your password or register with a different email ID.</p>
</div>
</body>
</html>