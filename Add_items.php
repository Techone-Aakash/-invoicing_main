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
$_SESSION['ERROR'] = 'Please Update Your Profile First for Adding Items';
header("location:profile.php");
}
mysqli_free_result($result);
}
include 'header.php';
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Submit'])){
for( $i=0; $i<count($_POST['colTwo']); $i++){
$sub_cat = mysqli_real_escape_string($conn ,$_POST["colTwo"][$i]);
$itm_name = mysqli_real_escape_string($conn ,$_POST["colThree"][$i]);
$hsn = mysqli_real_escape_string($conn ,$_POST["colFour"][$i]);
$GST = mysqli_real_escape_string($conn ,$_POST["colFive"][$i]);

$sqlhsn = "SELECT product FROM item_table_user where HSN = '$hsn' AND USERNAME = '".$_SESSION['USERNAME']."' ";
$res = mysqli_query($conn, $sqlhsn);
if(mysqli_num_rows($res) == 0 ){
$add_items = "INSERT INTO item_table_user (USERNAME,Category,product,HSN,GST) VALUES ('".$_SESSION["USERNAME"]."', '$sub_cat', '$itm_name', '$hsn', '$GST' )";
if(mysqli_query($conn, $add_items)){
$_SESSION['ERROR'] = 'Product has been Added Successfully...';
}
}else{
$row = mysqli_fetch_assoc($res);
$_SESSION['ERROR'] = "'".$row['product']."' having same '". $hsn ."' code , Please try different hsn code" ;
}mysqli_free_result($res);
}
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<title>Create - <?php echo $_SESSION['USERNAME'];?></title>
</head>
<body onload="main();">
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <div class="mt-4 w-100 d-inline-flex"><h1 class="w-50">ITEMS</h1>
        <div class="d-flex flex-row-reverse w-50">
          <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#Add_item"><i class="fa fa-plus-circle me-1"></i>Add Item</button>
        </div>
      </div>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">All Items</li>
      </ol>
      <div class="card mb-4 bg-transparent">
        <div class="card-header">
          <i class="fab fa-product-hunt me-1"></i>
          All Added Items
        </div>
        
        <div class="card-body" >
          <?php
          if(isset($_SESSION["ERROR"])){
          echo '<div class="d-flex px-2  py-1 alert-primary h5">'.$_SESSION["ERROR"].'</div>';
          }?>
          <div class="d-flex px-2 my-1 py-1 alert-danger h5"><b class="px-1">*</b>Fields are Mandatory</div>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <table class="table table-responsive mt-4 text-center" id="datatablesSimple">
              <thead class="text-center">
                <tr>
                  <th class="text-center">S.no</th>
                  <th class="text-center">Sub-Category</th>
                  <th class="text-center">Product Name</th>
                  <th class="text-center">HSN/Code</th>
                  <th class="text-center">GST (in %)</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM item_table_user WHERE USERNAME = '".$_SESSION['USERNAME']."' ORDER BY(product) ASC";
                if($result = mysqli_query($conn,$sql)){
                for($i=1; $i<=mysqli_num_rows($result); $i++){
                $row = mysqli_fetch_assoc($result);
                ?>
                <tr>
                  <td class='text-center px-2'><?php echo $i;?></td>
                  <td class='text-center px-2'><?php echo $row["Category"]; ?></td>
                  <td class='text-center px-2 text-capitalize'><?php echo $row["product"]; ?></td>
                  <td class='text-center px-2'><?php echo $row["HSN"]; ?></td>
                  <td class='text-center px-2'><?php echo $row["GST"]; ?></td>
                  <td class='text-center px-2'><a href='Delete_Item.php?id=<?php echo $row["id"];?>' class="text-decoration-none" onclick="return confirm('Would you want to delete this?');"><input type="hidden" name="id" value=$id><i class="fa fa-trash-alt text-danger mx-1"></i>Delete</a></td>
                </tr>
                <?php
                $var_for_last_gst = $row["GST"];
                }mysqli_free_result($result);
                } ?>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="Add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Items</h5>
            <button type="button" class="close btn" tabindex='-1' data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" class="m-auto" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
              <div id="static" class="px-5">
                <div class="position-absolute" style="margin-left:-50px; float: left; top:25%;">
                  <div class="d-inline-flex">
                    <button type="button" accesskey="c" class="btn btn-primary border rounded-circle my-1" tabindex='-1' style="height: 40px; width: 40px;" onclick="Create();">
                    <h5>+</h5></button>
                  </div><br>
                  <div class="d-inline-flex">
                    <button type="button" class="btn btn-primary border rounded-circle" style="height: 40px; width: 40px;" tabindex='-1' accesskey="d" onclick="Delete();">
                    <h5>-</h5></button>
                  </div>
                </div>
                <table class="table table-responsive mt-4 text-center" >
                  <thead class="text-center">
                    <tr>
                      <th >S.no</th>
                      <th class="px-4">Sub_Category<span>*</span></th>
                      <th class="px-2">Product_Name<span>*</span></th>
                      <th class="">HSN/Code<span>*</span></th>
                      <th class="px-2">GST(in%)<span>*</span></th>
                    </tr>
                  </thead>
                <tbody id="mytable"></tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
              </table>
            </div>
            <div class="text-center">
              <input type="submit" name="Submit" value="Save"  accesskey="s" class="btn btn-success px-3 m-2" />
              <input type="reset" accesskey="r" value="Reset" class="btn btn-danger px-3 m-2" />
            </div>
          </form>
          <div class="small">
            <b><u>Try Creating Typical Hsn/Code...</u></b><br>
            <p>Like if your Category is Clothing Then
              Jeans is Available for Boys, Mens as well Girls Also.
            Then it became a Tedious task to Analyze product Of Which Category.</p>
            <ul><i>
              <li>For Men use Prefix M...</li>
              <li>For Women use Prefix W...</li>
              <li>For Girls use Prefix G...</li>
              <li>For Boys use Prefix B...</li>
            </i></ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <script>
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
  })
  </script> -->
  <style>
  ::-webkit-scrollbar {
  height: 10px !important;
  width : 10px !important;
  }
  #static{
  overflow: auto;
  height:auto;
  max-height:320px ;
  }
  #static thead tr th{
  position: -webkit-sticky;
  position: sticky;
  background: white;
  top: 0px;
  box-shadow: inset 0 -7px 1px -6px black;
  }
  span{color: red; font-weight: 900; margin-left: 3px;}
  input{text-align: center;}
  select{text-align-last: center;}
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
  .btn{
  padding: 3px 12px  !important;
  }
  }
  </style>
</main>
<?php
include 'footer.php';
//echo '<script src="invoice.js"></script>';
?>
<script>
var count = 0;
var item_list=[<?php
$sql= "SELECT Category FROM profile WHERE USERNAME = '".$_SESSION['USERNAME']."' ";
if($category = mysqli_query($conn, $sql)){
$row = mysqli_fetch_assoc($category);
$sql= "SELECT sub_category FROM item_table WHERE category = '".$row["Category"]."' ";
if($sub_category = mysqli_query($conn, $sql)){
for($i=0; $i<mysqli_num_rows($sub_category); $i++){
$row1 = mysqli_fetch_assoc($sub_category);
echo $row1["sub_category"];
}
mysqli_free_result($sub_category);
}
mysqli_free_result($category);
}else{
header('location:404.html');
}
?>];
function Create() {
++count;
var html = "<tr>";
  html += "<td id='colOne" + count + "'>" + count + "</td>";
  // category
  html += "<td>"
    html += "<select class='form-control' id='colTwo" + count + "' name='colTwo[]' data-type='productCategory' required >";
      html += "<option value> --SELECT-- </option>"
      for (let i = 0; i < item_list.length; i++) {
      html += "<option value='" + item_list[i] + "'>" + item_list[i] + "</option>"
      }
    html += "</select>";
  html += "</td>";
  html += "<td><input type='text' class='form-control' data-type='productName'  id='colThree"+count+"' name='colThree[]' required/></td>";
  html += "<td><input type='text' class='form-control' data-type='productCode' value='" + count + "' id='colFour"+count+"' name='colFour[]' required /></td>" ;
  html += "<td><input type='number' class='form-control' data-type='productGst' step='any' value='<?php echo $var_for_last_gst; ?>' id='colFive"+count+"' name='colFive[]' required /></td>";
  html += "</tr>";
document.getElementById("mytable").insertRow().innerHTML = html;
}
function Delete() {
var table = document.getElementById("mytable");
count = --count;// count - 1
if (count == 0) { count++; }
else {
count;
table.deleteRow(-1);
}
return count - 1;
}
function main(){
Create();
Create();
Create();
}
</script>
<?php
unset($_SESSION['ERROR']);
mysqli_close($conn);
?>