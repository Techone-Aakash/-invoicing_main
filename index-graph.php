    <!--  <script src="assets/demo/chart-area-demo.js"></script>-->
    <?php
    session_start();
    include 'connect.php';
    if(!isset($_SESSION["USERNAME"])){
    header("location:login.php");
    exit();
   }

    $sql = "SELECT Sum(grand_total) as grand_total , _DATE  FROM customers_data WHERE USERNAME='".$_SESSION['USERNAME']."' And MODE != 'Cancelled'  GROUP BY DATE(_DATE) DESC limit 10";
    if($result = mysqli_query($conn,$sql)){
    $last =array();
    $last_ten_date = array();
    $last_ten_sales =array();
    
    for($i=0; $i<mysqli_num_rows($result); $i++){
    $rows = mysqli_fetch_assoc($result);
    $last[$i] = strtotime($rows['_DATE']);
    $last_ten_date[$i] = date('d M', $last[$i]);
    $last_ten_sales[$i] = $rows['grand_total'];
    //echo $last_ten_date[$i].'<br>'.$last_ten_sales[$i].'<br>';
    }
    mysqli_free_result($result);
    }
    ?>
    <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    Chart.defaults.global.defaultFontStyle="bold";

    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: [<?php
    $last_ten_date = array_reverse($last_ten_date);
    foreach($last_ten_date as $dates) {
    echo  '"'.$dates.'",';
    }?>],
    datasets: [{
    label: "Total",
    lineTension: 0.2,
    backgroundColor: ['#007bff'],
    borderColor: "#dc3545",
    pointRadius: 6,
    pointBackgroundColor: "#28a745",
    pointBorderColor: "rgba(255,255,255, 0.8)",
    pointHoverRadius: 6,
    pointHitRadius: 50,
    pointBorderWidth: 2,
    data: [<?php
    $last_ten_sales = array_reverse($last_ten_sales);
    foreach($last_ten_sales as $sales) {
    echo  $sales.',';
    }?>],
    }],
    },
    options: {
    scales: {
    xAxes: [{
    time: {
    unit: 'date'
    },
    gridLines: {
    display: false
    },
    ticks: {
    maxTicksLimit: 10
    }
    }],
    yAxes: [{
    ticks: {
    min: 0,
    max: <?php
    $max=0;
    foreach ($last_ten_sales as $value) {
     if ($value > $max){
      $max = $value; 
    }}
    //echo $max;
    $input = '0';
    $b = str_repeat("0", strlen($max));
    $c = '1'.$b;
    //echo " ".$c;
    if ( $max > $c/2 ) {
        if($max <= $c /*100000*/ && $max > ($c*95)/100 /*95000*/){
            echo $c;

        }elseif($max <= ($c*95)/100 /*95000*/ && $max > ($c*90)/100 /*90000*/){
            echo ($c*95)/100 ;

        }elseif ($max <= ($c*90)/100 /*90000*/ && $max > ($c*85)/100 /*85000*/) {
            echo ($c*90)/100 ;

        }elseif($max <= ($c*85)/100 /*85000*/ && $max > ($c*80)/100 /*80000*/){
            echo ($c*85)/100 ;

        }elseif ($max <= ($c*80)/100 /*80000*/ && $max > ($c*75)/100 /*75000*/) {
            echo ($c*80)/100 ;

        }elseif($max <= ($c*75)/100 /*75000*/ && $max > ($c*70)/100 /*70000*/){
            echo ($c*75)/100 ;

        }elseif ($max <= ($c*70)/100 /*70000*/ && $max > ($c*65)/100/*65000*/) {
            echo ($c*70)/100 ;

        }elseif($max <= ($c*65)/100 /*65000*/ && $max > ($c*60)/100 /*60000*/){
            echo ($c*65)/100 ;

        }elseif($max <= ($c*60)/100/*60000*/ && $max > ($c*55)/100 /*55000*/) {
            echo ($c*60)/100 ;
        
        }else{
            echo ($c*55)/100 ;
        }

    }elseif ( $max < $c/2 ) {
        if($max <= ($c*50)/100 /*50000*/ && $max > ($c*45)/100 /*45000*/){
            echo ($c*50)/100 ;

        }elseif($max <= ($c*45)/100 /*45000*/ && $max > ($c*40)/100 /*40000*/){
            echo ($c*45)/100 ;

        }elseif ($max <= ($c*40)/100 /*40000*/ && $max > ($c*35)/100 /*35000*/) {
            echo ($c*40)/100 ;

        }elseif($max <= ($c*35)/100 /*35000*/ && $max > ($c*30)/100 /*30000*/){
            echo ($c*35)/100 ;

        }elseif ($max <= ($c*30)/100 /*30000*/ && $max > ($c*25)/100 /*25000*/) {
            echo ($c*30)/100 ;

        }elseif($max <= ($c*25)/100 /*25000*/ && $max > ($c*20)/100 /*20000*/){
            echo ($c*25)/100 ;

        }elseif ($max <= ($c*20)/100 /*20000*/ && $max > ($c*15)/100/*15000*/) {
            echo ($c*20)/100 ;

        }elseif($max <= ($c*15)/100 /*15000*/ && $max > ($c*10)/100 /*10000*/){
            echo ($c*15)/100 ;

        }elseif($max <= ($c*10)/100/*10000*/ && $max > ($c*5)/100 /*5000*/) {
            echo ($c*10)/100 ;

        }else{
            echo ($c*5)/100 ;
        }
    }else{
            echo $c/2 ;
    } ?>,   
    maxTicksLimit: 8
   },
    gridLines: {
    color: "rgba(0, 0, 0, .125)",
    }
    }],
    },
    legend: {
    display: false
    }
    }
    });
    </script>
    <?php
    $sql = "SELECT SUM(grand_total) as grand_total, _DATE FROM customers_data WHERE USERNAME='".$_SESSION['USERNAME']."' And MODE != 'Cancelled' GROUP BY MONTH(_DATE) DESC LIMIT 6";
    if($result = mysqli_query($conn,$sql)){
    $last =array();
    $last_six_months = array();
    $last_six_months_sales =array();
    
    for($i=0; $i<mysqli_num_rows($result); $i++){
    $rows = mysqli_fetch_assoc($result);
    $last[$i] = strtotime($rows['_DATE']);
    $last_six_months[$i] = date('F', $last[$i]);
    $last_six_months_sales[$i] = $rows['grand_total'];
    //echo $last_six_months[$i].'<br>'.$last_six_months_sales[$i].'<br>';
    }
    mysqli_free_result($result);
    }
    
    ?>
    <script>
// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [<?php
   $last_six_months = array_reverse($last_six_months);
    foreach($last_six_months as $months) {
    echo '"'. $months .'",';
    }?>],
    datasets: [{
    label: "Revenue",
    backgroundColor: ['#007bff', '#33FFC7', '#ffc107', '#28a745', '#7CDDDD'],
    borderColor: '#dc3545',
    borderWidth: 2.5,
      data: [<?php 
      $last_six_months_sales = array_reverse($last_six_months_sales);
      foreach($last_six_months_sales as $data)
         echo $data.',' ;
        ?>],
    }],
  },
  options: {
    scales: {
      xAxes: [{
      //  barPercentage: .8,
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php
         $max = 0;
         foreach ($last_six_months_sales as $data) {
             if($data > $max){
                $max = $data;
             }
         }
    //  echo $max;
    $input = '0';
    $b = str_repeat("0", strlen($max));
    $c = '1'.$b;
    // echo $c;
    if ( $max > $c/2 ) {

        if($max <= ($c*95)/100 /*95000*/ && $max > ($c*90)/100 /*90000*/){
            echo ($c*95)/100 ;

        }elseif ($max <= ($c*90)/100 /*90000*/ && $max > ($c*85)/100 /*85000*/) {
            echo ($c*90)/100 ;

        }elseif($max <= ($c*85)/100 /*85000*/ && $max > ($c*80)/100 /*80000*/){
            echo ($c*85)/100 ;

        }elseif ($max <= ($c*80)/100 /*80000*/ && $max > ($c*75)/100 /*75000*/) {
            echo ($c*80)/100 ;

        }elseif($max <= ($c*75)/100 /*75000*/ && $max > ($c*70)/100 /*70000*/){
            echo ($c*75)/100 ;

        }elseif ($max <= ($c*70)/100 /*70000*/ && $max > ($c*65)/100/*65000*/) {
            echo ($c*70)/100 ;

        }elseif($max <= ($c*65)/100 /*65000*/ && $max > ($c*60)/100 /*60000*/){
            echo ($c*65)/100 ;

        }elseif($max <= ($c*60)/100/*60000*/ && $max > ($c*55)/100 /*55000*/) {
            echo ($c*60)/100 ;
        
        }else{
            echo ($c*55)/100 ;
        }

    }elseif ( $max < $c/2 ) {

        if($max <= ($c*45)/100 /*45000*/ && $max > ($c*40)/100 /*40000*/){
            echo ($c*45)/100 ;

        }elseif ($max <= ($c*40)/100 /*40000*/ && $max > ($c*35)/100 /*35000*/) {
            echo ($c*40)/100 ;

        }elseif($max <= ($c*35)/100 /*35000*/ && $max > ($c*30)/100 /*30000*/){
            echo ($c*35)/100 ;

        }elseif ($max <= ($c*30)/100 /*30000*/ && $max > ($c*25)/100 /*25000*/) {
            echo ($c*30)/100 ;

        }elseif($max <= ($c*25)/100 /*25000*/ && $max > ($c*20)/100 /*20000*/){
            echo ($c*25)/100 ;

        }elseif ($max <= ($c*20)/100 /*20000*/ && $max > ($c*15)/100/*15000*/) {
            echo ($c*20)/100 ;

        }elseif($max <= ($c*15)/100 /*15000*/ && $max > ($c*10)/100 /*10000*/){
            echo ($c*15)/100 ;

        }elseif($max <= ($c*10)/100/*10000*/ && $max > ($c*5)/100 /*5000*/) {
            echo ($c*10)/100 ;

        }else{
            echo ($c*5)/100 ;
        }
    }else{
            echo $c/2 ;
    } ?>,
          maxTicksLimit: 10
        },
        gridLines: {

          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
    </script>