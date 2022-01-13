<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["USERNAME"])){
header("location:login.php");
exit();
}
include 'connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM item_table_user WHERE id = $id AND USERNAME = '".$_SESSION['USERNAME']."' ";
if(mysqli_query($conn,$sql)){
 $_SESSION['ERROR'] = "Deleted Successfully";
}
header("location:Add_items.php");
mysqli_close($conn);
?>