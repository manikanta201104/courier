<?php

session_start();

if (isset($_SESSION["uid"]) && $_SESSION["uid"] === true) {
    header("location: home/home.php");
    exit;
}
?>