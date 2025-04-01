<?php
session_start();
if (!isset($_SESSION['uid'], $_SESSION['email'])) {
    header('location: ../index.php');
    exit; 
}

include('header.php');

$email = $_SESSION['email'];
$uid = $_SESSION['uid'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    include('../dbconnection.php');

    // Sanitize inputs (you should validate inputs more thoroughly in a real-world application)
    $sname = mysqli_real_escape_string($dbcon, $_POST['sname']);
    $rname = mysqli_real_escape_string($dbcon, $_POST['rname']);
    $semail = mysqli_real_escape_string($dbcon, $_POST['semail']);
    $remail = mysqli_real_escape_string($dbcon, $_POST['remail']);
    $sphone = mysqli_real_escape_string($dbcon, $_POST['sphone']);
    $rphone = mysqli_real_escape_string($dbcon, $_POST['rphone']);
    $sadd = mysqli_real_escape_string($dbcon, $_POST['saddress']);
    $radd = mysqli_real_escape_string($dbcon, $_POST['raddress']);
    $wgt = mysqli_real_escape_string($dbcon, $_POST['wgt']);
    $billn = mysqli_real_escape_string($dbcon, $_POST['billno']);
    $originalDate = $_POST['date'];
    $newDate = date("Y-m-d", strtotime($originalDate));

    // Handle file upload
    $imagenam = $_FILES['simg']['name'];
    $tempnam = $_FILES['simg']['tmp_name'];
    $uploadPath = "../dbimages/" . basename($imagenam);

    if (move_uploaded_file($tempnam, $uploadPath)) {
        // Insert data into database
        $qry = "INSERT INTO `courier` (`sname`, `rname`, `semail`, `remail`, `sphone`, `rphone`, `saddress`, `raddress`, `weight`, `billno`, `image`, `date`, `u_id`) VALUES ('$sname', '$rname', '$semail', '$remail', '$sphone', '$rphone', '$sadd', '$radd', '$wgt', '$billn', '$imagenam', '$newDate', '$uid');";

        if (mysqli_query($dbcon, $qry)) {
?>
            <script>
                alert('Order Placed Successfully :)');
                window.open('courierMenu.php', '_self');
            </script>
<?php
        } else {
            echo "Error: " . mysqli_error($dbcon);
        }
    } else {
        echo "Error uploading file.";
    }

    mysqli_close($dbcon);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div style="overflow-x:auto;">
            <table border="0px solid" style="margin: auto; font-weight:bold;border-spacing: 5px 15px;">
                <th colspan="4" style="text-align: center;background-color:#00FF00; width: 140px; height: 50px;">Fill The Details Of Sender & Receiver</th>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <hr>
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <th colspan="2">SENDER</th>
                    <th colspan="2">RECEIVER</th>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="sname" placeholder="Sender FullName" required></td>

                    <td>Name:</td>
                    <td><input type="text" name="rname" placeholder="Receiver FullName" required></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="semail" value="<?php echo htmlspecialchars($email); ?>" readonly></td>

                    <td>Email:</td>
                    <td><input type="text" name="remail" placeholder="Receiver EmailId" required></td>
                </tr>
                <tr>
                    <td>PhoneNo.:</td>
                    <td><input type="text" name="sphone" placeholder="Sender number" required></td>

                    <td>PhoneNo.:</td>
                    <td><input type="text" name="rphone" placeholder="Receiver number" required></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type="text" name="saddress" placeholder="Sender address" required></td>

                    <td>Address:</td>
                    <td><input type="text" name="raddress" placeholder="Receiver address" required></td>
                </tr>
                <tr>
                    <td colspan="4">➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖➖</td>
                </tr>
                <tr>
                    <td>Weight:</td>
                    <td><input type="text" name="wgt" placeholder="weights in kg" required></td>

                    <td>Payment Id:</td>
                    <td><input type="text" name="billno" placeholder="enter transaction num" required></td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td><input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" readonly /></td>
                    <td>Items Image:</td>
                    <td><input type="file" name="simg"></td>
                </tr>
                <tr>
                    <td colspan="4" align="center"><input type="submit" name="submit" value="Place Order" style="background-color: orange; border-radius: 15px; width: 140px; height: 50px;cursor:pointer;"></td>
                </tr>
            </table>
        </div>
    </form>
</body>

</html>
