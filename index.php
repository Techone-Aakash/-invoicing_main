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
<title>Dashboard - <?php echo $_SESSION['USERNAME'];?></title>
</head>
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <?php
        $data_not_found_error = "SELECT USERNAME FROM customers_data WHERE USERNAME='".$_SESSION['USERNAME']."' ";
        $chk1 = mysqli_query($conn, $data_not_found_error);
        if(mysqli_num_rows($chk1) == 0){
        include 'data_not_found_error.html';
        }else{
        include 'expenses.php';
        ?>
        
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4 bg-transparent">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Last 10 Day Sales
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4 bg-transparent">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Last 6 Months Sales
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="card mb-4 bg-transparent">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Last 20 Invoice Generated
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead class="card-header text-center pr-2'">
                        <tr>
                            <th class='text-center px-2'>Invoice</th>
                            <th class='text-center px-2'>Name</th>
                            <th class='text-center px-2'>Address</th>
                            <th class='text-center px-2'>Date</th>
                            <th class='text-center px-2'>Amount</th>
                            <th class='text-center px-2'>Payment Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM customers_data WHERE USERNAME='".$_SESSION['USERNAME']."' Order by id desc LIMIT 20";
                        if($result = mysqli_query($conn,$sql)){
                        for($i=1; $i<=mysqli_num_rows($result); $i++){
                        $row = mysqli_fetch_assoc($result);?>
                        <tr>
                            <td class='text-center px-2'><?php echo $row["INVOICE_ID"] ?></td>
                            <td class='text-center px-2'><?php echo $row["_NAME"] ?></td>
                            <td class='text-center px-2'><?php echo $row["_ADDRESS"] ?></td>
                            <td class='text-center px-2'><?php echo date('d/m/y',    strtotime($row['_DATE'])) ?></td>
                            <td class='text-center px-2'><?php echo IND_money_format($row["grand_total"]) ?></td>
                            <td class='text-center px-2 h6

                                            <?php
                                            if ($row["MODE"] == "Paid") {
                                                echo "text-success'>";
                                            }elseif ($row["MODE"] == "Unpaid") {
                                                echo "text-warning'>";
                                            }else {
                                                echo "text-danger'>";
                                            }
                                            echo $row["MODE"] ; ?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</div>
</main>
<?php
include 'footer.php';
include 'index-graph.php';
function IND_money_format($number){
$decimal = (string)($number - floor($number));
$money = floor($number);
$length = strlen($money);
$delimiter = '';
$money = strrev($money);
for($i=0;$i<$length;$i++){
if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
$delimiter .=',';
}
$delimiter .=$money[$i];
}
$result = strrev($delimiter);
$decimal = preg_replace("/0\./i", ".", $decimal);
$decimal = substr($decimal, 0, 3);
if( $decimal != '0'){
$result = $result.$decimal;
}
return $result;
}
mysqli_close($conn);
?>