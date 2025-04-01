<?php
include('../dbconnection.php');


if(isset($_GET['em'])) {

    $em = mysqli_real_escape_string($dbcon, $_GET['em']);

    $qry = "DELETE FROM `users` WHERE `email`='$em'";
    $run = mysqli_query($dbcon, $qry);

    if($run) {

        ?>
        <script>
            alert('User Removed Successfully :)');
            window.location.href = 'deleteusers.php';
        </script>
        <?php
    } else {
       
        ?>
        <script>
            alert('Failed to remove user. Please try again.');
            window.location.href = 'deleteusers.php';
        </script>
        <?php
    }
} else {
   
    header('location: error.php');
    exit(); 
}
?>
