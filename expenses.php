<div class="card mb-4">
    <div class="card-header h6"><i class="fa fa-chart-line me-1"></i>This month analytics</div>
    <div class="row header card-body ">
        <div class="col-xl-3 col-md-6">
            <div class="card mb-3">
                <?php
                $sql= "SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE USERNAME = '".$_SESSION['USERNAME']."' AND `MODE` != 'Cancelled' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 1";
                //SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE  USERNAME = 'Akash123' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 1;
                $result1 = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result1);
                ?>
                <div class="card-body h6">Sales</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php
                    echo 'Rs '.IND_money_format($row['grand_sum']);                 
                    mysqli_free_result($result1);
                ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-3">
                <?php
                $sql= "SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE USERNAME = '".$_SESSION['USERNAME']."' AND `MODE` != 'Cancelled' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 2";
                //SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE  USERNAME = 'Akash123' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 2;
               if($result1 = mysqli_query($conn, $sql)){
                for ($i=0; $i<mysqli_num_rows($result1); $i++) { 
                    $row1 = mysqli_fetch_assoc($result1);
                }
                ?>
                <div class="card-body h6">Overall Growth</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php
                   //for total sales of this month
                   // $row['grand_sum'];
                   //for total sales of this month
                   //$row1['grand_sum'];
                    $growth = (($row['grand_sum']-$row1['grand_sum'])/$row1['grand_sum'])*100;

                    if($row1['grand_sum']<$row['grand_sum']){
                    echo "<span class='text-success'>+".IND_money_format($growth) ." %</span>";
                    }else{
                    echo "<span class='text-danger'>".IND_money_format($growth) ." %</span>";
                    }                 
                    mysqli_free_result($result1);
                }
                ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-3">
                <?php
                $sql= "SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE `MODE` = 'Paid' AND USERNAME = '".$_SESSION['USERNAME']."' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 1";
                $result1 = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result1);
                //SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE `MODE` = 'Paid' AND USERNAME = 'Akash123' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 1;
                ?>
                <div class="card-body h6">Amount Paid</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                <?php
                    echo 'Rs '.IND_money_format($row['grand_sum']);
                    mysqli_free_result($result1);
                ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-3">
                <?php
                $sql= "SELECT SUM(`grand_total`) AS grand_sum, _DATE FROM customers_data WHERE `MODE` = 'Unpaid' AND USERNAME = '".$_SESSION['USERNAME']."' GROUP BY month(`_DATE`) ORDER BY(_DATE) DESC LIMIT 1";
                $result1 = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result1);
                ?>
                <div class="card-body h6">Amount Payable</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php
                    echo 'Rs '.IND_money_format($row['grand_sum']);
                    mysqli_free_result($result1);?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.header{
padding-bottom: 0px !important;
}
.header .card{
background: #ddd6f3;
background: -webkit-linear-gradient(to right, #faaca8, #ddd6f3);
background: linear-gradient(to right, #faaca8, #ddd6f3);
}
.card .card-footer{
background: whitesmoke;
opacity: 75%;
font-weight: 600;
}
</style>