<?php 
session_start();
if(!isset($_SESSION["adminUserid"]) && !isset($_SESSION["admin"])) {
    header("Location:login.php");
}

?>