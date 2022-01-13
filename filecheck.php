<?php
include 'connect.php';
error_reporting(0);
$target_dir = "C:/xampp/htdocs/uploads/".$_SESSION['USERNAME']."_";
$file_name = $target_dir . basename($_FILES["var13"]["name"]);
$original_file = basename($_FILES["var13"]["name"]);
$file_size = $_FILES['var13']['size'];
$file_tmp = $_FILES['var13']['tmp_name'];
$file_type = $_FILES['var13']['type'];
$file_ext=strtolower(end(explode('.',$_FILES['var13']['name'])));

$extensions= array("jpeg","jpg","png");

if(!$_FILES["var13"]["name"] == ""){
if(in_array($file_ext,$extensions)== false){
$file_error="Please choose a JPEG, JPG or PNG file.";
}else{
if($file_size > 500000) {
$file_error='File size should be Less than 500 kb';
}else{
if(!isset($file_error)) {
$sql = "SELECT Logo_Path FROM profile WHERE user='".$_SESSION['USERNAME']."' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$target_del = $target_dir.$row['Logo_Path'] ;
unlink($target_del);
move_uploaded_file($file_tmp, $file_name);
//echo "Success";
mysqli_free_result($result);
}else{
$file_error = "Sorry, there was an error uploading your file.";
}
}
}
}
?>