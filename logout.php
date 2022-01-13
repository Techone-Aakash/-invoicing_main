<?php
session_start();
session_unset();
//require_once "config.php";
//unset($_SESSION['access_token']);
//$google_client->revokeToken();
session_destroy();
header("location:login.php");
exit();
?>