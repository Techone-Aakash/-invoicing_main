<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["USERNAME"])){
header("location:login.php");
exit();
}
include 'connect.php';
include 'header.php';
if(!isset($_GET["id"])){
header('location:Invoices.php');
}
if(!isset($_SESSION["id"])){
$_SESSION["id"] = $_GET["id"];
unset($_SESSION['invoice_id']);
}
$check_mode="SELECT Mode From customers_data WHERE (id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."') AND (Mode != 'Cancelled' AND total_sc_gst!=0.00)";
  $check_mode_row = mysqli_query($conn, $check_mode);
  // echo mysqli_num_rows($check_mode_row);
  if(mysqli_num_rows($check_mode_row) == 0){
    $_SESSION['ERROR'] = "Invoice can not be Edited.";
    header('location:Invoices.php');
  }
          

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Update"]) ){
$cus_name = mysqli_real_escape_string($conn, $_POST["tab2na"] );
$cus_mobile = mysqli_real_escape_string($conn, $_POST["tab2mo"] );
$cus_gst = mysqli_real_escape_string($conn, $_POST["tab2gs"] );
$cus_address = mysqli_real_escape_string($conn, $_POST["tab2ad"] );
$cus_email = mysqli_real_escape_string($conn, $_POST["tab2em"] );
$cus_state = mysqli_real_escape_string($conn, $_POST["tab2st"] );
$PAYMENT_MODE = mysqli_real_escape_string($conn, $_POST["payment"] );
$total_qty = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["total_qty"]));
$total_amount = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["total_amount"]));
$total_sgst = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["total_sgst"]));
$Round_Off = mysqli_real_escape_string($conn, $_POST["Round_Off"]);
$grand_total = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["grand_total"]));
$sql_customers = "UPDATE customers_data SET _NAME='$cus_name',MOBILE='$cus_mobile',GSTIN='$cus_gst',_ADDRESS='$cus_address',EMAIL='$cus_email',_STATE='$cus_state',MODE='$PAYMENT_MODE',total_qty='$total_qty',total_amount='$total_amount',total_sc_gst='$total_sgst',Round_Off='$Round_Off',grand_total='$grand_total' WHERE id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."' ";
if(mysqli_query($conn, $sql_customers) ){
for($a=0; $a<count($_POST["colTwo"]); $a++){
$item = mysqli_real_escape_string($conn,$_POST["col2val"][$a]);
$hsn = mysqli_real_escape_string($conn,$_POST["colThree"][$a]);
$qty = mysqli_real_escape_string($conn,$_POST["colFour"][$a]);
$rate = mysqli_real_escape_string($conn,$_POST["colFive"][$a]);
$gst   = mysqli_real_escape_string($conn,$_POST["col6val"][$a]);
$sgst = mysqli_real_escape_string($conn,str_replace("," ,"" , $_POST["colSix"][$a]));
$total=mysqli_real_escape_string($conn,str_replace("," ,"" , $_POST["colEight"][$a]));
$sql_order_details = "UPDATE order_data SET ITEM='$item' , HSN='$hsn' , QTY='$qty' , RATE='$rate' , GST='$gst' , S_C_GST='$sgst' , TOTAL='$total' , edit='1' WHERE edit='0' AND cus_id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."' ORDER BY id ASC LIMIT 1";
mysqli_query($conn , $sql_order_details);
// echo "<br<br><br>".$sql_order_details[$a]."<br>";
}
$sql_edit = "UPDATE order_data SET edit='0' WHERE cus_id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."' ";
if(mysqli_query($conn , $sql_edit)){
header("location:print_invoice.php");
}else{
header("location:500.html");
}
}else{
header("location:500.html");
}
}
?>
<title>Edit - <?php echo $_SESSION['USERNAME'];?></title>
</head>
<body>
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Invoices</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Invoice</li>
      </ol>
      <div class="card mb-4 bg-transparent">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Invoices
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
              <div class="d-inline-flex text-uppercase">GSTIN:- <?php echo $prof_row["Gst"]; ?></div><br/>
            </div>
            
            <?php
            $cust_sql="SELECT * From customers_data WHERE id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."' ";
            if($cust_result = mysqli_query($conn, $cust_sql)){
            $cust_row = mysqli_fetch_assoc($cust_result);
            ?>
            
            <div class="col-sm-4 m-auto d-block">
              <div class="h5 text-primary d-flex px-2 flex-row-reverse">Invoice no. : <?php echo " ".$cust_row["INVOICE_ID"]; ?></div>
              <div class="h5 text-primary d-flex px-2 flex-row-reverse">Date :<?php echo " ".date("d/m/y",strtotime($cust_row["_DATE"]));?></div>
            </div>
          </div>
          
          <div class="d-flex px-2 my-3 py-1 alert-danger h5"><b class="px-1">*</b>Fields are Mandatory</div>
          <div>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class="border border-primary rounded-bottom">
              <div id="tab2">
                <div class="text-center py-4 "><h4  class="border-bottom border-secondary d-inline">Tax Invoice</h4></div>
                <div class="row " style="padding:0 5%;">
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Party Name<span>*</span></span>
                      </div>
                      <input type="text" class="form-control text-capitalize" placeholder="Party Name" value="<?php echo $cust_row['_NAME']; ?>" name="tab2na">
                    </div>
                  </div>
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text px-2">Phone no<span>*</span></span>
                      </div>
                      <input type="tel" maxlength="10" class="form-control text-capitalize" placeholder="Phone no" value="<?php echo $cust_row['MOBILE']; ?>" name="tab2mo">
                    </div>
                  </div>
                </div>
                <div class="row " style="padding:0 5%;">
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text  px-4">Address<span>*</span></span>
                      </div>
                      <input type="text" class="form-control text-capitalize" placeholder="Address" value="<?php echo $cust_row['_ADDRESS']; ?>" name="tab2ad">
                    </div>
                  </div>
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text  px-4">GSTIN</span>
                      </div>
                      <input type="text" maxlength="15" class="form-control text-uppercase" placeholder="GST no" value="<?php echo $cust_row['GSTIN']; ?>" name="tab2gs">
                    </div>
                  </div>
                </div>
                <div class="row " style="padding:0 5%;">
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text  px-2">Supply State<span>*</span></span>
                      </div>
                      <select class="form-control text-capitalize " name="tab2st">
                        <option value="<?php echo $cust_row["_STATE"]; ?>"><?php echo $cust_row["_STATE"]; ?></option>
                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                        <option value="Daman and Diu">Daman and Diu</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="Puducherry">Puducherry</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text px-3">E-mail Id</span>
                      </div>
                      <input type="Email" class="form-control text-capitalize" placeholder="Email-Id" value="<?php echo $cust_row['EMAIL']; ?>" name="tab2em">
                    </div>
                  </div>
                </div>
              </div>
              <?php } mysqli_free_result($cust_result); ?>
              <div class="mx-4 " id="static">
                <table id="tab3" class="table table-responsive mt-4" >
                  <thead class="text-center">
                    <tr>
                      <th >S.no</th>
                      <th class="px-5">Description<span>*</span></th>
                      <th class="px-3">Hsn/Code</th>
                      <th class="px-5 text-center">Qty<span>*</span> (pcs/m)</th>
                      <th class="px-5">Price<span>*</span></th>
                      <th class="px-5">S-GST</th>
                      <th class="px-5">C-GST</th>
                      <th class="px-5">Amount</th>
                    </tr>
                  </thead>
                  <tbody id="mytable">
                    <?php
                    $sql_ord ="SELECT * FROM order_data WHERE cus_id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."' ";
                    if($ord_result = mysqli_query($conn, $sql_ord)){
                    for($j=1; $j<=mysqli_num_rows($ord_result); $j++){
                    $ord_row = mysqli_fetch_assoc($ord_result);
                    ?>
                    <tr>
                      <td id="colOne<?php echo $j;?>"><?php echo $j;?></td>
                      <td>
                        <input type="hidden" id="col2val<?php echo $j;?>" value="<?php echo $ord_row["ITEM"] ;?>" name="col2val[]">
                        <select class="form-control text-capitalize" id="colTwo<?php echo $j;?>" name="colTwo[]" data-type="productName" required="" onchange="selectoption(this)">
                          <option value="<?php echo $ord_row["HSN"]."|".$ord_row["GST"];?>"><?php echo $ord_row["ITEM"] ;?></option>
                          <?php
                          $itm_sql = "SELECT * FROM item_table_user WHERE USERNAME = '".$_SESSION["USERNAME"]."' ORDER BY(product) ASC";
                          if($itm_result = mysqli_query($conn,$itm_sql)){
                          for($i=0; $i<mysqli_num_rows($itm_result); $i++) {
                          $itm_row = mysqli_fetch_assoc($itm_result);
                          echo "<option value=".$itm_row["HSN"]."|".$itm_row["GST"]." >".$itm_row["product"]."</option>" ;
                          }
                          mysqli_free_result($itm_result);
                          }else{
                          echo "<option value= >Not Listed Items Yet</option>";
                          }
                          ?>
                        </select>
                      </td>
                      <td>
                        <input type="text" class="form-control text-capitalize" data-type="productCode" id="colThree<?php echo $j;?>" name="colThree[]" value="<?php echo $ord_row["HSN"] ;?>" tabindex="-1" readonly="">
                      </td>
                      <td>
                        <input type="number" class="form-control" data-type="productQuantity" value="<?php echo $ord_row["QTY"] ;?>" id="colFour<?php echo $j;?>" name="colFour[]" required="" oninput="Calculate()">
                      </td>
                      <td>
                        <input type="number" class="form-control" data-type="productRate" step="any" placeholder="0" id="colFive<?php echo $j;?>" value="<?php echo $ord_row["RATE"] ;?>" name="colFive[]" required="" oninput="Calculate()">
                      </td>
                      <td>
                        
                        <input type="hidden" id="col6val<?php echo $j;?>" value="<?php echo $ord_row["GST"] ;?>" name="col6val[]" />
                        <div class="input-group">
                          <div class="input-group-prepend"><span id="colSixGst<?php echo $j;?>" class="input-group-text"><?php echo $ord_row["GST"]."%" ;?></span></div>
                          <input type="text" class="form-control" data-type="productSgst" id="colSix<?php echo $j;?>" name="colSix[]" value="<?php echo IND_money_format($ord_row["S_C_GST"]) ;?>" tabindex='-1' readonly />
                        </div>

                       <!--  <input type="text" class="form-control" data-type="productSgst" id="colSix<?php echo $j;?>" name="colSix[]" value="<?php echo IND_money_format($ord_row["S_C_GST"]) ;?>" tabindex="-1" readonly=""> -->
                      </td>

                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend"><span id="colSevenGst<?php echo $j;?>" class="input-group-text"><?php echo $ord_row["GST"]."%" ;?></span></div>
                          <input type="text" class="form-control" data-type="productCgst" id="colSeven<?php echo $j;?>" name="colSeven[]" value="<?php echo IND_money_format($ord_row["S_C_GST"]) ;?>" tabindex="-1" readonly />
                        </div>
                      </td>

                      <!-- <td>
                        <input type="text" class="form-control" data-type="productCgst" id="colSeven<?php echo $j;?>" name="colSeven[]" value="<?php echo IND_money_format($ord_row["S_C_GST"]) ;?>" tabindex="-1" readonly="">
                      </td> -->
                      <td>
                        <input type="text" class="form-control" data-type="productTotal" id="colEight<?php echo $j;?>" name="colEight[]" value="<?php echo IND_money_format($ord_row["TOTAL"]) ;?>" tabindex="-1" readonly="">
                      </td>
                    </tr>
                    <?php }} mysqli_free_result($ord_result); ?>
                  </tbody>
                  <tfoot>
                  <?php
                  $cust_sql="SELECT * From customers_data WHERE id = '".$_SESSION["id"]."' AND USERNAME = '".$_SESSION["USERNAME"]."' ";
                  if($cust_result = mysqli_query($conn, $cust_sql)){
                  $cust_row = mysqli_fetch_assoc($cust_result);
                  ?>
                  <tr>
                    <td colspan="3"><div class="d-flex flex-row-reverse">Total Qty<div></td>
                    <td><input class="form-control" type="text" id="total_qty" name="total_qty" value="<?php echo IND_money_format($cust_row['total_qty']); ?>" tabindex="-1" readonly /></td>
                    <td colspan="3"><div class="d-flex flex-row-reverse">Rs.<div></td>
                    <td><input class='form-control' type="text" id="total_amount" name="total_amount" value="<?php echo IND_money_format($cust_row['total_amount']); ?>" tabindex="-1" readonly /></td>
                  </tr>
                  <tr>
                    <td colspan="7"><div class="d-flex flex-row-reverse">S-GST<div></td>
                    <td><input class='form-control' type="text" id="total_sgst" name="total_sgst" value="<?php echo IND_money_format($cust_row['total_sc_gst']); ?>" tabindex="-1" readonly /></td>
                  </tr>
                  <tr>
                    <td colspan="4"><div class="d-flex ">Payment Status <span class="h5 mx-2 ">*</span>
                    <select name="payment" class='form-control mx-3 p-1 w-25' required onchange="PaymentOption(this);">
                      <option value="<?php echo $cust_row['MODE']; ?>"><?php echo $cust_row['MODE'] ; ?></option>
                      <option value="Paid">Paid</option>
                      <option value="Unpaid">Unpaid</option>
                    </select></div>
                  </td>
                  <td colspan="3"><div class="d-flex flex-row-reverse">C-GST<div></td>
                  <td><input class='form-control' type="text" id="total_cgst"  value="<?php echo IND_money_format($cust_row['total_sc_gst']); ?>" tabindex="-1" readonly /></td>
                </tr>
                <tr>
                  <td colspan="7"><div class="d-flex flex-row-reverse">Round-Off<div></td>
                  <td><input class='form-control' type="text" id="Round_Off" name="Round_Off" value="<?php echo $cust_row['Round_Off']; ?>" tabindex="-1" readonly /></td>
                </tr>
                <tr>
                  <td colspan="7"><div class="d-flex flex-row-reverse">Total Rs.</div>
                  <div class="d-flex flex-row-reverse small"><i>( inclusive of all taxes )</i></div>
                </td>
                <td><input class='form-control' type="text" id="grand_total" name="grand_total" value="<?php echo IND_money_format($cust_row['grand_total']); ?>" tabindex="-1" readonly /></td>
              </tr>
              <?php } mysqli_free_result($cust_result); ?>
              </tfoot>
            </table>
          </div>
          <div class="text-center">
            <input type="submit" name="Update" value="Update"  accesskey="u" class="btn btn-success px-3 m-2" />
            <input type="reset" accesskey="r" value="Reset" class="btn btn-danger px-3 m-2" />
          </div>
        </form>
        <style>
        ::-webkit-scrollbar {
        height: 10px !important;
        width : 10px !important;
        }
        #static{
        overflow: auto;
        height:520px;
        }
        #static thead tr th{
        position: -webkit-sticky;
        position: sticky;
        background: white;
        top: 0px;
        z-index: 1;
        box-shadow: inset 0 -7px 1px -6px black;
        }
        span{color: red; font-weight: 900; margin-left: 3px;}
        input{text-align: center;}
        select{text-align-last: center;}
        th,td{font-weight: 600;}
        @media only screen and (max-width:660px) {
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
        .card-body{
        font-size: 80% !important;
        }
        .text-primary{
        font-size: 110% !important;
        }
        .alert-danger {
        font-size: 120% !important;
        }
        form{
        font-size: 105% !important;
        }
        #static tbody tr input, select, tfoot tr input{
        padding: 3px !important;
        }
        #tab2 .row{
        padding: 0 3% !important;
        }
        .input-group-text , .input-group input,.input-group select {
        font-size: 93% !important;
        z-index: -1;
        }
        .input-group-text, .input-group input,.input-group select {
        padding: 4px 8px  !important;
        }
        .btn{
        padding: 3px 12px  !important;
        }
        }
        </style>
      </div>
      <div class="p-2 border-bottom border-danger">
        <h5 class="alert-danger p-1">Remarks</h5>
        <div class="px-2 text-capitalize">
          <li><?php echo $prof_row["Terms1"]; ?></li>
          <li><?php echo $prof_row["Terms2"]; ?></li>
          <li><?php echo $prof_row["Terms3"]; ?></li>
        </div>
      </div>
      <div class="row pt-2 pb-0">
        <div class="col-sm-8 ">
          <h5 class="alert-danger d-inline-flex px-3">Bank Account Details</h5>
          <ul>
            <li>Account Name :-<label class="text-uppercase"><?php echo " ".$prof_row["Ac_n"]; ?></label></li>
            <li>Account Number :-<label class="text-uppercase"><?php echo " ".$prof_row["Ac_no"]; ?></label></li>
            <li>IFS Code :-<label class="text-uppercase"><?php echo " ".$prof_row["Ac_ifsc"]; ?></label> </li>
          </ul>
        </div>
        <div class="col-sm-4 d-flex flex-row-reverse">
          <div class="d-block">
            <h5 class="d-flex flex-row-reverse alert-danger px-3">Account Manager</h5><br>
            <!--<img draggable="false" src="signature.bmp" width="200px"/><br>-->
            <label class="text-capitalize"> For : <?php echo $prof_row["First_n"]." ".$prof_row["Middle_n"]." ".$prof_row["Last_n"]; ?></label>
          </div>
        </div>
      </div>
      <div class="text-center text-primary border-top border-danger h6">Thank you !!</div>
      
    </div>
    <?php  mysqli_free_result($prof_result);
    }
    ?>
  </div>
</div>
</main>
<?php
include 'footer.php';
//echo '<script src="invoice.js"></script>';
?>
<script>

// function selectoption() {
// for (i = 1; i < i + 1; i++) {
// let x = document.getElementById("colTwo" + [i]);
// document.getElementById("colThree" + [i]).value = x.value;
// var value = x.options[x.selectedIndex].value;// get selected option value
// var text = x.options[x.selectedIndex].text;
// document.getElementById("col2val" + [i]).value = text;
// }
// }

function selectoption() {
let qty = 0.00;
let sgst_cgst = 0.00;
let total = 0.00;
let grand_total = 0.00;
let Round = 0.00;

for (i = 1; i < i + 1; i++) {
let x = document.getElementById("colTwo" + [i]);
x2 = x.value;
console.log(x2);
const myArr = x2.split("|");
  document.getElementById("colThree" + [i]).value =  myArr[0];
  document.getElementById("col6val" + [i]).value = myArr[1];
  document.getElementById("colSixGst" + [i]).textContent = document.getElementById("colSevenGst" + [i]).textContent = myArr[1]+"%";
  var value = x.options[x.selectedIndex].value;// get selected option value
  var text = x.options[x.selectedIndex].text;
  document.getElementById("col2val" + [i]).value = text;


    let num1 = document.getElementById("colFour" + i).value;
    let num2 = document.getElementById("colFive" + i).value;
    let gstval = document.getElementById("col6val" + i).value;
    let num4 = parseFloat(num1 * num2).toFixed(2);
    let num3 = parseFloat((num4 * gstval) / 100).toFixed(2);
    if (num1 == 0 || num2 == 0) {
    document.getElementById('colSix' + i).value = "";
    document.getElementById('colSeven' + i).value = "";
    document.getElementById('colEight' + i).value = "";
    } else {
    document.getElementById('colSix' + i).value = numberWithCommas(num3);
    document.getElementById('colSeven' + i).value = numberWithCommas(num3);
    document.getElementById('colEight' + i).value = numberWithCommas(num4);
    }
    qty += parseFloat(num1);
    sgst_cgst += parseFloat(num3);
    total += parseFloat(num4);
    grand_total = parseFloat(sgst_cgst) + parseFloat(sgst_cgst) + parseFloat(total);
    Round = Math.round(grand_total) - grand_total
    document.getElementById('total_amount').value = numberWithCommas(total);
    document.getElementById('total_qty').value = numberWithCommas(qty);
    document.getElementById('total_sgst').value = numberWithCommas(sgst_cgst);
    document.getElementById('total_cgst').value = numberWithCommas(sgst_cgst);
    document.getElementById('Round_Off').value = Round.toFixed(2);
    document.getElementById('grand_total').value = numberWithCommas(Math.round(grand_total));
    } return grand_total;
}



function numberWithCommas(x) {
var num = new Number(x);
return num.toLocaleString("en-IN");
}

function Calculate() {
let qty = 0.00;
let sgst_cgst = 0.00;
let total = 0.00;
let grand_total = 0.00;
let Round = 0.00;
for (let i = 1; i <= i+1; i++) {
let num1 = document.getElementById("colFour" + i).value;
let num2 = document.getElementById("colFive" + i).value;
let gstval = document.getElementById("col6val" + i).value;
let num4 = parseFloat(num1 * num2).toFixed(2);
let num3 = parseFloat((num4 * gstval) / 100).toFixed(2);
if (num1 == 0 || num2 == 0) {
document.getElementById('colSix' + i).value = "";
document.getElementById('colSeven' + i).value = "";
document.getElementById('colEight' + i).value = "";
} else {
document.getElementById('colSix' + i).value = numberWithCommas(num3);
document.getElementById('colSeven' + i).value = numberWithCommas(num3);
document.getElementById('colEight' + i).value = numberWithCommas(num4);
}
qty += parseFloat(num1);
sgst_cgst += parseFloat(num3);
total += parseFloat(num4);
grand_total = parseFloat(sgst_cgst) + parseFloat(sgst_cgst) + parseFloat(total);
Round = Math.round(grand_total) - grand_total
document.getElementById('total_amount').value = numberWithCommas(total);
document.getElementById('total_qty').value = numberWithCommas(qty);
document.getElementById('total_sgst').value = numberWithCommas(sgst_cgst);
document.getElementById('total_cgst').value = numberWithCommas(sgst_cgst);
document.getElementById('Round_Off').value = Round.toFixed(2);
document.getElementById('grand_total').value = numberWithCommas(Math.round(grand_total));
} return grand_total;
}


</script>
<?php
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