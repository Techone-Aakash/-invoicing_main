<?php
session_start();
error_reporting(0);
include 'connect.php';
if(!isset($_SESSION["USERNAME"])){
header("location:login.php");
exit();
}
include 'header.php';
?>
<title>Analytics - <?php echo $_SESSION['USERNAME']; ?></title>
</head>
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Analytics</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Analytics</li>
        </ol>

        <?php
        $data_not_found_error = "SELECT USERNAME FROM customers_data WHERE USERNAME='".$_SESSION['USERNAME']."' ";
        $chk1 = mysqli_query($conn, $data_not_found_error);
        if(mysqli_num_rows($chk1) == 0){
        include 'data_not_found_error.html';
        }else{ ?>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Last 10 day Sales
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
            <div class="card-footer small text-muted">Updated 1 minute ago</div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Last Six Months Sale
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                    <div class="card-footer small text-muted">Updated 1 minute ago</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Top Selling Item's
                    </div>
                    <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                    <div class="card-footer small text-muted">Updated 1 minute ago</div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</main>
<?php
include 'footer.php';
include 'index-graph.php';
?>
<?php
$sql = "SELECT order_data.ITEM, sum(order_data.QTY) AS grand_item , customers_data.MODE FROM order_data INNER JOIN customers_data ON order_data.cus_id=customers_data.id WHERE order_data.USERNAME ='". $_SESSION['USERNAME']."' AND customers_data.MODE != 'Cancelled' GROUP BY order_data.ITEM ORDER BY grand_item DESC LIMIT 5";
//echo '<br>'.$sql.'<br>';
if($result = mysqli_query($conn,$sql)){
// $item = array();
$item_sum = array();
$item_name = array();
for($i=0; $i<mysqli_num_rows($result); $i++){
$rows = mysqli_fetch_assoc($result);
$item_sum[$i] = $rows['grand_item'];
$item_name[$i] = $rows['ITEM'];
//echo $item_sum[$i]."<br>".$item_name[$i]."<br>";
}
mysqli_free_result($result);
}
?>
<script>
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
type: 'doughnut',
data: {
labels: [<?php
foreach($item_name as $name) {
echo  '"'.$name.'",';
}?>],
datasets: [{
//  data: [12.21, 15.58, 11.25, 8.32, 10.5],
backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#7CDDDD'],
data: [<?php
foreach($item_sum as $data)
echo $data.',' ;
?>],
}],
},
});
</script>
<?php
mysqli_close($conn);

// SELECT order_data.ITEM, sum(order_data.QTY) AS grand_item , customers_data.MODE FROM order_data INNER JOIN customers_data ON order_data.cus_id=customers_data.id WHERE order_data.USERNAME ='Aakash12' AND customers_data.MODE != 'Cancelled' GROUP BY order_data.ITEM, customers_data.MODE ORDER BY grand_item 

//SELECT order_data.ITEM, sum(order_data.QTY) AS grand_item , customers_data.MODE FROM order_data INNER JOIN customers_data ON order_data.cus_id=customers_data.id WHERE order_data.USERNAME ='Aakash12' AND customers_data.MODE != 'Cancelled' GROUP BY order_data.ITEM ORDER BY grand_item DESC LIMIT 5
?>