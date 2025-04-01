
<?php
    include('../dbconnection.php');
    $billno= $_REQUEST['bb'];

    $qry = "DELETE FROM `courier` WHERE `billno`='$billno'";
    $run = mysqli_query($dbcon,$qry);

    if($run==true){
    ?>  <script>
        alert('Courier Deleted Successfully :)');
        window.open('deletedata.php','_self');
        </script>
    <?php
}
?>