<?php
require_once "dbconnection.php"; // This should set $conn
require_once "session.php";

// Check if the connection is established
if (!isset($conn)) {
    die("Database connection failed. Please check dbconnection.php.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to fetch the user by email
    $qry = "SELECT * FROM `login` WHERE `email`=?";
    $stmt = mysqli_prepare($conn, $qry);
    if ($stmt === false) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) < 1) {
        $error_message = "Oops! Please enter your username and password again.";
        echo "<script>alert('$error_message');</script>";
    } else {
        $data = mysqli_fetch_assoc($result);
        $hashed_password = $data['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $id = $data['u_id'];
            $email = $data['email'];

            // Start the session and store user data
            session_start();
            $_SESSION['uid'] = $id;
            $_SESSION['email'] = $email;

            // Redirect to the home page
            header("Location: home/home.php");
            exit;
        } else {
            $error_message = "Oops! Please enter your username and password again.";
            echo "<script>alert('$error_message');</script>";
        }
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection (optional, as PHP will close it automatically at the end of the script)
// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/10.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <h1 align='center' style="margin: 15px; color:seagreen;font-weight: bold;font-family:'Times New Roman', Times, serif">IIITV-ICD COURIER SERVICE</h1>
    <hr />
    <p align='center' style="font-weight: bold;color:orange;font-family:'Times New Roman', Times, serif">The Fastest Courier Service Ever</p>
    <div>
        <h5><a href="admin/adminlogin.php" style="float: right; margin-right:40px; color:blue; margin-top:0px">Admin Login</a></h5>
    </div>
    <div class="container" style="margin-top: 60px; width:50%;">
        <div class="row">
            <div class="col-md-12">
                <h2 style="color: #273c75;">Login</h2>
                <p style="color:#e84118;">Please Fill Your ⮯⮯</p>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter username/emailId" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Sign In" />
                        <button onclick="window.location.href='resetpswd.php'" class="btn btn-danger" style="cursor:pointer">Reset Password</button>
                    </div>
                    <p style="color: #e84118;">Don't have an account? ⮞➤ <a href="register.php">Register here</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>