<?php
session_start();
if(isset($_SESSION['uid'])){
    echo "";
    }else{
    header('location: ../index.php');
    }

?>
<?php
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        body {
            background-color: #f9f9fa;
            padding-top: 50px; 
        }

        .padding {
            padding: 5rem !important;
        }

        .user-card-full {
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 1px 40px 0 rgba(69, 90, 100, 0.1); 
        }

        .bg-c-lite-green {
            background: linear-gradient(to right, #ee5a6f, #f29263);
        }

        .user-profile {
            padding: 30px 0; 
            border-radius: 20px 0 0 20px; 
        }

        .card-block {
            padding: 2rem; 
        }

        .img-radius {
            border-radius: 30px; 
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .social-link li a {
            font-size: 24px;
            margin-right: 20px; 
            color: #495057; 
        }

        .email-container {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    
<?php

include('../dbconnection.php');
$id= $_SESSION['uid'];
$qry= "SELECT * FROM `users` WHERE `u_id`='$id'";
$run= mysqli_query($dbcon,$qry);

$data = mysqli_fetch_assoc($run);

?>

<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-8 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                                <h3 class="f-w-600"><?php echo $data['name']; ?></h3>
                                <p>user</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <div class="email-container">
                                            <h6 class="text-muted f-w-400"><?php echo $data['email']; ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Phone</p>
                                        <h6 class="text-muted f-w-400"><?php echo $data['pnumber']; ?></h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <hr><br><hr>
                                </div>
                                <ul class="social-link list-unstyled m-t-40 m-b-10">
                                    <h6>Leave it when u can't hold it..</h6>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
