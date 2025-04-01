<?php
session_start();
if(!isset($_SESSION['uid'])){
    header('location: ../login.php');
    exit;
}

include('head.php');
include('../dbconnection.php');

// Handle user deletion
if(isset($_GET['emm'])){
    $email = $_GET['emm'];

    $qry = "DELETE FROM `users` WHERE `email` = ?";
    $stmt = mysqli_prepare($dbcon, $qry);

    if($stmt){
        mysqli_stmt_bind_param($stmt, "s", $email);
        $execute = mysqli_stmt_execute($stmt);

        if($execute){
            header('Location: '.$_SERVER['PHP_SELF'].'?msg=User Deleted Successfully');
            exit;
        } else {
            echo "<div style='text-align: center; color: red;'>Error deleting user.</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div style='text-align: center; color: red;'>Error preparing statement.</div>";
    }
}

// Display success or error message if any
if(isset($_GET['msg'])){
    echo "<div style='text-align: center; color: green;'>" . $_GET['msg'] . "</div>";
}
?>

<div class="admintitle">
    <div>
        <h5><a href="dashboard.php" style="float: left; margin-left:20px; color:aliceblue;">BackToDashboard</a></h5>
        <h5><a href="logout.php" style="float: right; margin-right:20px; color:aliceblue;">LogOut</a></h5>
    </div>
    <h1 align='center' style="text-shadow: 0.1em 0.1em 0.15em #f9829b;">Showing All Users</h1>
</div>
<div style="overflow-x:auto;">
<table width='80%' border="1" style="margin-left: auto; margin-right:auto; margin-top:30px; font-weight:bold;border-collapse: collapse;">
    <tr style="background-color: #fff;">
        <th>No.</th>
        <th>Users Name</th>
        <th>Email Id</th>
        <th>Action</th>
    </tr>
    <?php

        $qry= "SELECT * FROM `users`"; 
        $run= mysqli_query($dbcon, $qry);

        if(mysqli_num_rows($run) < 1){
            echo "<tr><td colspan='4'>There is no Data in Database</td></tr>";
        } else {
            $count = 0;
            while($data = mysqli_fetch_assoc($run)){
                $count++;
    ?>
            <tr align="center">
                <td><?php echo $count; ?></td>
                <td><?php echo $data['name']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?emm=<?php echo $data['email']; ?>">DeleteUser</a></td>
            </tr>
    <?php
            }
        }
    ?>
</table>
</div>
