<!-- <?php
// session_start();
// error_reporting(0);
// if(!isset($_SESSION["USERNAME"])){
// header("location:login.php");
// exit();
// }
// include 'connect.php';
// $C_id =$_GET['id'];
// $sql1 = "DELETE FROM customers_data WHERE id = $C_id AND USERNAME ='".$_SESSION['USERNAME']."' ";
// if(mysqli_query($conn,$sql1)){
// 	$sql2 = "DELETE FROM order_data WHERE cus_id = $C_id AND USERNAME ='".$_SESSION['USERNAME']."' ";
// 	if(mysqli_query($conn,$sql2)){
// 		header("location:Invoices.php");
// 		}
// }else{
// header("location:500.html");    
// }
// mysqli_close($conn);
?> -->


<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["USERNAME"])){
header("location:login.php");
exit();
}
include 'connect.php';
$C_id =$_GET['id'];

$sql1 = "UPDATE customers_data SET MODE='Cancelled' WHERE id = $C_id AND USERNAME ='".$_SESSION['USERNAME']."' ";
if(mysqli_query($conn,$sql1)){
		header("location:Invoices.php");
}else{
header("location:500.html");
}
mysqli_close($conn);
?>