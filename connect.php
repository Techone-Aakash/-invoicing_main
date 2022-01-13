<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "test1";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);
     if (!$conn) {                                     
        die("Failed due to ". mysqli_connect_error());    
    }
?>