<?php
session_start();
error_reporting(0);
if(isset($_SESSION["USERNAME"])){
  include 'connect.php';
  $sql = "SELECT * FROM profile WHERE USERNAME = '".$_SESSION['USERNAME']."' ";
  if(!mysqli_query($conn, $sql)){
  header("location:404.html");
  }



if(isset($_GET['id'])){
$get_id = $_GET['id'];  
}elseif(isset($_SESSION["sales_invoice_id"])){
$ses_id = $_SESSION['sales_invoice_id'];
unset($_SESSION['sales_invoice_id']);
}elseif(isset($_SESSION["id"])){
$get_id = $_SESSION['id'];
unset($_SESSION['id']);
}else{
header("location:invoices_sales.php");
}


}else{
header("location:login.php");
exit();
}
include 'header.php';
?>
<title>Print - <?php echo $_SESSION['USERNAME'];?></title>
</head>
<body>
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Print</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Print Invoice</li>
      </ol>
      <div class="card mb-4 bg-transparent">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Print
        </div>
        <?php
        $sql="SELECT * From profile WHERE USERNAME= '".$_SESSION["USERNAME"]."' ";
        if($prof_result = mysqli_query($conn, $sql)){
        $prof_row = mysqli_fetch_assoc($prof_result);
        ?>
        <div class="card-body">
          <div class="text-center"><?php echo $prof_row["Moto"]; ?></div>
          <div class="row border-bottom border-danger rounded-bottom" >
            <div class="col-sm-8 mb-1 text-capitalize">
              <div class="display-5 mb-0" style="font-family: Gabriola; margin-bottom:-15px ; color:saddlebrown;" class="d-inline-flex">
              <?php echo $prof_row["Comp_n"]; ?></div>
              <div class="d-inline-flex"><?php echo $prof_row["Address1"]; ?></div><br/>
              <div class="d-inline-flex"><?php echo $prof_row["Address2"]." - ".$prof_row["Zip"].", ".$prof_row["City"].", ".$prof_row["_State"]; ?></div><br/>
              <div class="d-inline-flex"><?php echo $prof_row["Ph1"].", ".$prof_row["Ph2"]; ?></div><br/>
              <div class="d-inline-flex"><?php echo $prof_row["Email"]; ?></div><br/>
            </div>


            <?php
                $sql = "SELECT * FROM customers_data WHERE (INVOICE_ID = '$ses_id' OR id='$get_id') AND (total_sc_gst=0.00 AND USERNAME = '".$_SESSION['USERNAME']."') ";
                if($cus_result = mysqli_query($conn,$sql)){
                $row = mysqli_fetch_assoc($cus_result);
                ?>
            
            <div class="col-sm-4 m-auto d-block">
              <div class="h5 text-primary d-flex px-2 flex-row-reverse">Invoice no. :<?php echo $row["INVOICE_ID"]; ?></div>
              <div class="h5 text-primary d-flex px-2 flex-row-reverse">Date :<?php echo " ". date("d/m/y", strtotime($row["_DATE"])) ; ?>  </div>
            </div>
          </div>
          <div id="tab2" class="mb-4">
            <div class="card-body">
              <div class="text-center mb-2"><h5  class="border-bottom border-secondary d-inline">Sales Invoice</h5></div>
              <div class="row  px-2" style="font-weight: 500;">
                
                
                <div class="col-sm-6 mb-1" style="border-right: 1px solid red;">
                  <div class="row w-100 my-2">
                    <div class="col-sm-4 text-secondary text-secondary" >Party Name</div>
                    <div class="col-sm-8 text-center border-bottom border-dark text-capitalize "><?php echo $row["_NAME"]; ?></div>
                  </div>
                  <div class="row w-100 my-2">
                    <div class="col-sm-4 text-secondary" >Address</div>
                    <div class="col-sm-8 text-center border-bottom border-dark"><?php echo $row["MOBILE"]; ?></div>
                  </div>
                </div>
                <div class="col-sm-6 mb-1">
                  <div class="row w-100 my-2">
                    <div class="col-sm-3 text-secondary" >Phone</div>
                    <div class="col-sm-9 text-center border-bottom border-dark text-capitalize "><?php echo $row["_ADDRESS"]; ?></div>
                  </div>
                  <div class="row w-100 my-2">
                    <div class="col-sm-3 text-secondary" >State</div>
                    <div class="col-sm-9 border-bottom border-dark text-center text-capitalize "><?php echo $row["_STATE"]; ?></div>
                  </div>
                </div>
              </div>
              <div>
                <div class="mx-4 overflow-auto" id="static">
                  <table id="tab3" class="table table-responsive mt-4 " >
                    <thead class="text-center ">
                      <tr>
                        <th width="7%">S.no</th>
                        <th class="20%">Description</th>
                        <th width="11%">Hsn/<br>Code</th>
                        <th width="12%">Qty<h6 style="font-size:.75rem; font-weight:700;">(pcs/m)</h6></th>
                        <th width="13%">Price</th>
                        <th width="16%">Amount</th>
                      </tr>
                    </thead>
                    <tbody id="mytable">
                      <?php
                      $sql = "SELECT * FROM order_data WHERE cus_id = '".$row["id"]."' AND USERNAME= '".$_SESSION["USERNAME"]."' ";
                      if($ord_result = mysqli_query($conn,$sql)){
                      for ($i=1; $i <= mysqli_num_rows($ord_result); $i++) {
                      $row1 = mysqli_fetch_assoc($ord_result);
                      ?>
                      <tr>
                        <td ><?php echo $i; ?></td>
                        <td class="text-capitalize"><?php echo $row1["ITEM"]; ?></td>
                        <td class="text-capitalize"><?php echo $row1["HSN"]; ?></td>
                        <td><?php echo IND_money_format($row1["QTY"]); ?></td>
                        <td><?php echo IND_money_format($row1["RATE"]); ?></td>
                        <td><?php echo IND_money_format($row1["TOTAL"]); ?></td>
                      </tr>
                      <?php
                      }
                      mysqli_free_result($ord_result);
                      }
                      ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <td colspan="3"><div class="d-flex flex-row-reverse">Total Qty</div></td>
                      <td><?php echo IND_money_format($row["total_qty"]); ?></td>
                      <td colspan="1"><div class="d-flex flex-row-reverse">Rs.</div></td>
                      <td><?php echo IND_money_format($row["total_amount"]); ?></td>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <?php
                        if($row["MODE"] == 'Paid'){
                        echo '<img src="paid1.png" alt="Paid" height="100px" width="100px" draggable="false" style=" position: absolute;">';
                        }elseif ($row["MODE"] == 'Unpaid'){
                        echo '<img src="unpaid.jpg" alt="unpaid" height="100px" width="100px" draggable="false" style=" position: absolute;">';
                        }else{
                        echo '<img src="Cancelled.jpg" alt="Cancelled" height="100px" width="125px" draggable="false" style=" position: absolute;">';
                        }?>
                      </td>
                      <td colspan="2"><div class="d-flex flex-row-reverse">Round-Off</div></td>
                      <td><?php echo $row["Round_Off"]; ?></td>
                    </tr>
                    <tr>
                      <td colspan="5"><div class="d-flex flex-row-reverse">Total Rs.</div>
                      <div class="d-flex flex-row-reverse small"><i>( inclusive of all taxes )</i></div>
                    </td>
                    <td><?php echo IND_money_format($row["grand_total"]); ?></td>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <?php
              mysqli_free_result($cus_result);
              }
              ?>
              <div class="text-center">
                <input type='button' accesskey='p' value='Print' class='btn btn-warning px-3 m-2' onclick='window.print()' name='print' />
              </div>
              <style>
              ::-webkit-scrollbar {
              height: 10px !important;
              width : 10px !important;
              }
              table{
              border-collapse: collapse;
              }
              #static thead tr th{
              position: -webkit-sticky;
              position: sticky;
              background: white;
              top: 0px;
              box-shadow: inset 0 -7px 1px -6px black;
              }
              
              th,td{font-weight: 600; text-align: center;}
              main {
              top:0px !important;
              }
              
              @media only screen and (max-width:660px) {
              .card-body .text-center{
              font-size: .8rem;
              }
              .card-body .col-sm-6{
              border-right: none !important;
              }
              .rounded-bottom{
              font-size: .80rem;
              }
              .text-primary{
              font-size: 110% !important;
              }
              div[class="position-fixed"]{
              margin-top: -200px;
              margin-left: -17px !important;
              }
              div[class="position-fixed"] button  h5{
              font-size: 1rem;
              }
              div[class="position-fixed"] button {
              height:35px !important;
              width:35px !important;
              }
              #tab2 .col-sm-6{
              margin-bottom: 0 !important;
              padding: 0px  !important;
              }
              #tab2 .row{
              padding: 0px  !important;
              }
              #tab2 .row .col-sm-6{
              padding:0 10px  !important;
              }
              .w-100 .col-sm-8 ,.w-100 .col-sm-9 ,.w-100 .col-sm-4,.w-100 .col-sm-3{
              font-size: .82rem;
              margin-top: 10px;
              padding: 0px  !important;
              }
              .overflow-auto{
              margin: 0 !important;
              font-size: .82rem !important;
              }
              .alert-danger {
              font-size: .95em;
              font-weight: 700 !important;
              }
              .text-primary{
              margin-top: 10px !important;
              }
              .border-bottom .px-2, .px-1 {
              font-size: .85em;
              }
              .btn{
              padding: 3px 12px  !important;
              }
              }
              </style>
            </div>
            <div class="border-bottom border-danger pb-1" id="tab4">
              <h5 class="alert-danger p-1 px-2">Remarks</h5>
              <div class="px-3 text-capitalize">
                <li><?php echo $prof_row["Terms1"]; ?></li>
                <li><?php echo $prof_row["Terms2"]; ?></li>
                <li><?php echo $prof_row["Terms3"]; ?></li>
              </div>
            </div>
            <div class="row pt-1 pb-1" id="tab4">
              <div class="col-sm-8 ">
                <h5 class="alert-danger d-inline-flex p-1 px-2">Bank Account Details</h5>
                <ul>
                  <li>Account Name :-<label class="text-uppercase"><?php echo " ".$prof_row["Ac_n"]; ?></label></li>
                  <li>Account Number :-<label class="text-uppercase"><?php echo " ".$prof_row["Ac_no"]; ?></label></li>
                  <li>IFS Code :-<label class="text-uppercase"><?php echo " ".$prof_row["Ac_ifsc"]; ?></label> </li>
                </ul>
              </div>
              <div class="col-sm-4 d-flex flex-row-reverse">
                <div class="d-block">
                  <h5 class="d-flex flex-row-reverse alert-danger p-1 px-2">Account Manager</h5><br>
                  <!--<img draggable="false" src="signature.bmp" width="200px"/><br>-->
                  <label class="text-capitalize"> For : <?php echo $prof_row["First_n"]." ".$prof_row["Middle_n"]." ".$prof_row["Last_n"]; ?></label>
                </div>
              </div>
            </div>
            <div class="text-center text-primary border-top border-danger h6" style="margin-top:-15px;">Thank you !!</div>
            <style>
            @media print {
             *,
            *:before,
            *:after {
            background: transparent !important;
            color: #000 !important; // Black prints faster: h5bp.com/s
            box-shadow: none !important;
            text-shadow: none !important;
            }
            @page {
            size: A4;
            }
            body{
            color: black;
            padding-top:2mm !important;
            }

            /* tfoot{
              display: none;
            }*/


            /*for table font size*/
            #tab3, #tab4{
            font-size: .85em;
            }
            main{
            margin-top: -45px !important;
            }
            .rounded-bottom{
            padding: 0 15px !important;
            font-size:.95rem ;
            }
            span, footer, .sb-topnav, .breadcrumb, .btn-warning, .card-header {
            display: none;
            }
            #tab3 tfoot{
              display: table-header-group;
            }
            .card-header{
            display: none;
            padding: 0 !important;
            }
            .card-body{
            padding: 0 !important;
            border: none !important;
            }
            .card{
            padding: 0 !important;
            border: none !important;
            }
            #static{
            margin-top: -15px;
            }
            tfoot tr td,tbody tr td{ padding-top:0px  !important ; padding-bottom:0px  !important ;}
            .container-fluid h1 {
            display: none;
            padding: 0 !important;
            }
            .alert-danger{
            background: none !important;
            }
            }
            </style>
          </div>
        </div>
      </div>
      <?php  mysqli_free_result($prof_result);
      }
      ?>
    </div>
  </div>
</main>
<?php
include 'footer.php';
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