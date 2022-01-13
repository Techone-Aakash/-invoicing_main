<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["USERNAME"])){
header("location:login.php");
exit();
}
include 'connect.php';
$sql = "SELECT USERNAME FROM profile WHERE USERNAME = '".$_SESSION['USERNAME']."' ";
if($result = mysqli_query($conn,$sql)){
if(mysqli_num_rows($result) == 0){
$_SESSION["ERROR"] = "Please Update Your Profile First Before Generating Invoices";
mysqli_free_result($result);
header("location:profile.php");
}else{
$sql = "SELECT id FROM item_table_user WHERE USERNAME = '".$_SESSION['USERNAME']."' ";
if($result = mysqli_query($conn,$sql)){
if(mysqli_num_rows($result) == 0) {
$_SESSION["ERROR"] = "Please Add Item First Before Generating Invoices";
mysqli_free_result($result);
header("location:Add_items.php");
}
}
}
}
$set_invoice_id = "SELECT id FROM customers_data WHERE total_sc_gst!=0.00 AND USERNAME = '".$_SESSION['USERNAME']."' ";
if($result1 = mysqli_query($conn, $set_invoice_id)){
$insert_ID = mysqli_num_rows($result1) + 1;
$_SESSION["invoice_id"] = 'Inv-'.$insert_ID;
unset($_SESSION['id']);
mysqli_free_result($result1);
}
include 'header.php';
if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) ){
$cus_name = mysqli_real_escape_string($conn, $_POST["tab2na"]);
$cus_mobile = mysqli_real_escape_string($conn, $_POST["tab2mo"]);
$cus_gst = mysqli_real_escape_string($conn, $_POST["tab2gs"]);
$cus_address = mysqli_real_escape_string($conn, $_POST["tab2ad"]);
$cus_email = mysqli_real_escape_string($conn, $_POST["tab2em"]);
$cus_state = mysqli_real_escape_string($conn, $_POST["tab2st"]);
$PAYMENT_MODE = mysqli_real_escape_string($conn, $_POST["payment"]);
$total_qty = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["total_qty"]));
$total_amount = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["total_amount"]));
$total_sgst = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["total_sgst"]));
$Round_Off = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["Round_Off"]));
$grand_total = mysqli_real_escape_string($conn, str_replace("," ,"" , $_POST["grand_total"]));
$sql_customers = "INSERT INTO customers_data ( USERNAME, INVOICE_ID ,  _NAME, MOBILE, GSTIN, _ADDRESS, EMAIL, _STATE, MODE, total_qty, total_amount, total_sc_gst, Round_Off, grand_total ) VALUES ('".$_SESSION['USERNAME']."', '".$_SESSION['invoice_id']."' , '$cus_name' , '$cus_mobile' , '$cus_gst' , '$cus_address' , '$cus_email' , '$cus_state' , '$PAYMENT_MODE' , '$total_qty' , '$total_amount' , '$total_sgst' , '$Round_Off' , '$grand_total')";
if(mysqli_query($conn, $sql_customers)){
$last_id = mysqli_insert_id($conn);
// echo '<br><br><br><br>'.$sql_customers.'<br><br>';
for ($a=0; $a < count($_POST['colThree']); $a++){
$item   = mysqli_real_escape_string($conn,$_POST["col2val"][$a]);
$hsn    = mysqli_real_escape_string($conn,$_POST["colThree"][$a]);
$qty    = mysqli_real_escape_string($conn,$_POST["colFour"][$a]);
$rate   = mysqli_real_escape_string($conn,$_POST["colFive"][$a]);
$gst   = mysqli_real_escape_string($conn,$_POST["col6val"][$a]);
$sgst   = mysqli_real_escape_string($conn,str_replace(",","",$_POST["colSix"][$a]));
$total  = mysqli_real_escape_string($conn,str_replace(",","",$_POST["colEight"][$a]));
$sql_order_details  = "INSERT INTO order_data (cus_id , USERNAME, ITEM, HSN, QTY, RATE, GST, S_C_GST, TOTAL) VALUES ('$last_id' , '".$_SESSION['USERNAME']."' , '$item' , '$hsn' , '$qty' , '$rate' , '$gst' , '$sgst' , '$total' )";
// echo '<br><br><br><br>'.$sql_order_details.'<br><br>';
mysqli_query($conn , $sql_order_details);
}
header("location:print_invoice.php");
}else{
header("location:500.html");
}
}
?>
<title>Create - <?php echo $_SESSION['USERNAME'];?></title>
</head>
<body onload="main();">
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Invoices</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Create Invoice</li>
      </ol>
      <div class="card mb-4 bg-transparent">
        <div class="card-header">
          <i class="fas fa-file-invoice me-1 text-danger"></i>
          Create Invoice
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
            <div class="col-sm-4 m-auto d-block">
              <div class="h5 text-primary d-flex px-2 flex-row-reverse">Invoice no. :</div>
              <div class="h5 text-primary d-flex px-2 flex-row-reverse">Date :<?php echo " ".date('d/m/y'); ?>  </div>
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
                      <input type="text" class="form-control" placeholder="Party Name" name="tab2na">
                    </div>
                  </div>
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text px-2">Phone no<span>*</span></span>
                      </div>
                      <input type="tel" maxlength="10" class="form-control" value='0' name="tab2mo">
                    </div>
                  </div>
                </div>
                <div class="row " style="padding:0 5%;">
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text  px-4">Address<span>*</span></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Address" name="tab2ad">
                    </div>
                  </div>
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text  px-4">GSTIN</span>
                      </div>
                      <input type="text" maxlength="15" class="form-control" placeholder="GST no" name="tab2gs">
                    </div>
                  </div>
                </div>
                <div class="row " style="padding:0 5%;">
                  <div class="col-sm-6 ">
                    <div class="input-group mb-3 ">
                      <div class="input-group-prepend">
                        <span class="input-group-text  px-2">Supply State<span>*</span></span>
                      </div>
                      <select class="form-control " name="tab2st">
                        <option value="">--SELECT--</option>
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
                      <input type="Email" class="form-control" placeholder="Email-Id" name="tab2em">
                    </div>
                  </div>
                </div>
              </div>
              <div class="mx-4 " id="static">
                <div class="position-absolute" style="margin-left:-45px; float: left; top:57%;">
                  <div class="d-inline-flex">
                    <button type="button" accesskey="c" class="btn btn-primary border rounded-circle my-1" tabindex="-1" style="height: 40px; width: 40px;" onclick="Create();">
                    <h5>+</h5></button>
                  </div><br>
                  <div class="d-inline-flex">
                    <button type="button" class="btn btn-primary border rounded-circle" tabindex="-1" style="height: 40px; width: 40px;" accesskey="d" onclick="Delete();">
                    <h5>-</h5></button>
                  </div>
                </div>
                
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
                <tbody id="mytable"></tbody>
                <tfoot>
                <tr>
                  <td colspan="3"><div class="d-flex flex-row-reverse">Total Qty<div></td>
                  <td><input class="form-control" type="text" id="total_qty" name="total_qty" tabindex="-1" readonly /></td>
                  <td colspan="3"><div class="d-flex flex-row-reverse">Rs.<div></td>
                  <td><input class='form-control' type="text" id="total_amount" name="total_amount" tabindex="-1" readonly /></td>
                </tr>
                <tr>
                  <td colspan="7"><div class="d-flex flex-row-reverse">S-GST<div></td>
                  <td><input class='form-control' type="text" id="total_sgst" name="total_sgst" tabindex="-1" readonly /></td>
                </tr>
                <tr>
                  <td colspan="4"><div class="d-flex ">Payment Status <span class="h5 mx-2 ">*</span>
                  <select name="payment" class='form-control mx-3 p-1 w-25' required>
                    <option value>--SELECT--</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                  </select></div>
                </td>
                <td colspan="3"><div class="d-flex flex-row-reverse">C-GST<div></td>
                <td><input class='form-control' type="text" id="total_cgst"  tabindex="-1" readonly /></td>
              </tr>
              <tr>
                <td colspan="7"><div class="d-flex flex-row-reverse">Round-Off<div></td>
                <td><input class='form-control' type="text" id="Round_Off" name="Round_Off" tabindex="-1" readonly /></td>
              </tr>
              <tr>
                <td colspan="7"><div class="d-flex flex-row-reverse">Total Rs.</div>
                <div class="d-flex flex-row-reverse small"><i>( inclusive of all taxes )</i></div>
              </td>
              <td><input class='form-control' type="text" id="grand_total" name="grand_total" tabindex="-1" readonly /></td>
            </tr>
            </tfoot>
          </table>
        </div>
        
        <div class="text-center">
          <input type="submit" name="submit" value="Save"  accesskey="s" class="btn btn-success px-3 m-2" />
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
      z-index: 1 ;
      top: 0px;
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
      }
      .input-group-text, .input-group input,.input-group select {
      padding: 4px 8px  !important;
      }
      .input-group{
        z-index: -1 ;
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
?>
<script>
var count = 0;
function Create() {
++count;
var html = "<tr>";
html += "<td id='colOne" + count + "'>" + count + "</td>";
html += "<td>"
html += '<input type="hidden" id="col2val' + count + '" value="" name="col2val[]" />';
html += "<select class='form-control text-capitalize' id='colTwo" + count + "' name='colTwo[]' data-type='productName' required onchange='selectoption(this)'>";
  <?php
  $sql = "SELECT product,HSN,GST FROM item_table_user WHERE USERNAME = '".$_SESSION['USERNAME']."' ORDER BY(product) ASC";
  if($itm_res = mysqli_query($conn,$sql)){
  echo 'html += "<option value> --SELECT-- </option>";' ;
  for($i=0; $i<mysqli_num_rows($itm_res); $i++) {
  $itm_row = mysqli_fetch_assoc($itm_res);
  echo 'html += "<option value='.$itm_row["HSN"].'|'.floatval($itm_row["GST"]/ 2).' >'.$itm_row["product"].'</option>" ;';
  }
  mysqli_free_result($itm_res);
  }else{
  echo 'html += "<option value>Not Added Items Yet</option>";';
  }
  ?>
html += "</select>";
html += "</td>";
html += "<td><input type='text' class='form-control text-capitalize' data-type='productCode'  id='colThree"+count+"' name='colThree[]' value='' tabindex='-1' readonly /></td>";
html += "<td><input type='number' class='form-control' data-type='productQuantity' value='1' id='colFour"+count+"' name='colFour[]' required oninput='Calculate()' /></td>" ;
html += "<td><input type='number' class='form-control' data-type='productRate' step='any' placeholder='0' id='colFive"+count+"' name='colFive[]' required oninput='Calculate()' /></td>" ;

html += "<td><input type='hidden' id='col6val" + count + "' value='' name='col6val[]' /><div class='input-group'><div class='input-group-prepend'><span id='colSixGst"+count+"'class='input-group-text'>0</span></div><input type='text' class='form-control' data-type='productSgst' id='colSix"+count+"' name='colSix[]' value='' tabindex='-1' readonly /></div></td>";

html += "<td><div class='input-group'><div class='input-group-prepend'><span id='colSevenGst"+count+"'class='input-group-text'>0</span></div><input type='text' class='form-control' data-type='productCgst' id='colSeven"+count+"' name='colSeven[]' value='' tabindex='-1' readonly /></div></td>";


// html += "<td><input type='text' class='form-control' data-type='productCgst' id='colSeven"+count+"' name='colSeven[]' value='' tabindex='-1' readonly /></td>";
html += "<td><input type='text' class='form-control' data-type='productTotal' id='colEight"+count+"' name='colEight[]' value='' tabindex='-1' readonly /></td>";
html += "</tr>";
document.getElementById("mytable").insertRow().innerHTML = html;
}
</script>
<script src="invoice.js"></script>
<?php
mysqli_close($conn);
?>