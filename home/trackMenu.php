<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['uid'])) {

    header('Location: ../login.php');
    exit(); 
}


include('header.php');
?>

<div style="overflow-x:auto;">
    <table width='80%' border="1" style="margin-top:30px;margin:auto;font-weight:bold;border-spacing: 5px 5px;border-collapse: collapse;">
        <tr style="background-color: green;font-size:20px">
            <th>No.</th>
            <th>Item's Image</th>
            <th>Sender Name</th>
            <th>Receiver Name</th>
            <th>Receiver Email</th>
            <th>Action</th>
        </tr>

        <?php

        include('../dbconnection.php');

        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];

            $qryy = "SELECT * FROM `courier` WHERE `semail`='$email'";
            $run = mysqli_query($dbcon, $qryy);

            if (mysqli_num_rows($run) < 1) {

                echo "<tr><td colspan='6'>No records found..</td></tr>";
            } else {
                $count = 0;
                while ($data = mysqli_fetch_assoc($run)) {
                    $count++;
        ?>
                    <tr align="center">
                        <td><?php echo $count; ?></td>
                        <td><img src="../dbimages/<?php echo $data['image']; ?>" alt="pic" style="max-width: 100px;" /></td>
                        <td><?php echo $data['sname']; ?></td>
                        <td><?php echo $data['rname']; ?></td>
                        <td><?php echo $data['remail']; ?></td>
                        <td>
                            <a href="updationtable.php?sid=<?php echo $data['c_id']; ?>">Edit</a> ||
                            <a href="deletecourier.php?bb=<?php echo $data['billno']; ?>">Delete</a> ||
                            <a href="status.php?sidd=<?php echo $data['c_id']; ?>">Check Status</a>
                        </td>
                    </tr>
        <?php
                }
            }
        } else {
            echo "<tr><td colspan='6'>Session data not found.</td></tr>";
        }
        ?>
    </table>
</div>
