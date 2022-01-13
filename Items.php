<?php
session_start();
error_reporting(0);
include 'connect.php';
unset($_SESSION['id']);
if(!isset($_SESSION["USERNAME"])){
    header("location:login.php");
    exit();
   }
    $itm_tbl = "item_".$_SESSION["USERNAME"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Items - <?php echo $_SESSION['USERNAME'];?></title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
             <?php include 'sidenav.php'; ?>
            <div id="layoutSidenav_content">
                <main onload="main();">
                    <div class="container-fluid px-4">
                        
                            <div class="mt-4 w-100 d-inline-flex"><h1 class="w-50">Items</h1>
                                <div class="d-flex flex-row-reverse w-50">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Add_item">Add Item</button>
                                </div>
                            </div>
                        
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Items</li>
                        </ol>
                        <div class="card mb-4 bg-transparent">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Invoices 
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead class="card-header text-center pr-2'">
                                        <tr>
                                            <th class='text-center px-2'>S.no</th>
                                            <th class='text-center px-2'>Product Category</th>
                                            <th class='text-center px-2'>Product</th>
                                            <th class='text-center px-2'>Product Code</th>
                                            <th class='text-center px-2' colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM $itm_tbl";
                                        if($result = mysqli_query($conn,$sql)){
                                        for($i=1; $i<=mysqli_num_rows($result); $i++){
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                        <tr>
                                        <td class='text-center px-2'><?php echo $i; ?></td>
                                        <td class='text-center px-2'><?php echo $row["sub_category"] ; ?></td>
                                        <td class='text-center px-2'><?php echo $row["product"] ; ?></td>
                                        <td class='text-center px-2'><?php echo $row["HSN"] ; ?></td>
                                   
                                        <td class='text-center px-2'><a href='Add_items.php?id=<?php echo $row["id"];?>' class="text-decoration-none"><input type="hidden" name="id" value=$id alt="print"><i class="fa fa fa-edit text-success mx-1" ></i>Edit</a></td>
                                        
                                       <td class='text-center px-2'><a href='delete_items.php?id=<?php echo $row["id"];?>' class="text-decoration-none"><input type="hidden" name="id" value=$id><i class="fa fa-trash-alt text-danger mx-1"></i>Delete</a></td>
                                    </tr>
                                    <?php
                                    }
                                    }else{
                                    echo '<br>we can not connect right now<br>';
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


<div class="modal fade" id="Add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" style="max-width:650px; min-width: 200px; margin:auto;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <div class="d-flex px-2 my-3 py-1 alert-danger h5"><b class="px-1">*</b>Fields are Mandatory</div>
                    <div id="static">
                        <table class="table table-responsive mt-4 text-center" >
                            <thead class="text-center">
                                <tr>
                                    <th >S.no</th>
                                    <th class="px-5">SubCategory<span>*</span></th>
                                    <th class="px-5">Product Name<span>*</span></th>
                                    <th class="px-3">HSN/Code</th>
                                </tr>
                            </thead>
                            <tbody id="mytable">
                                <tr><td>1</td><td>78t7</td><td>saree</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                                <tr><td>1</td><td>78t7</td><td>saree</td><td>78t7</td></tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-success">Save</button>
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
        max-height:500px ;
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
            <footer class="py-4 bg-transparent mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Techone Aakash</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
<script>
var count = 0;
var item_list=[<?php
while($row = mysqli_fetch_assoc($result)) {
echo $row["sub_category"];
} ?>];
function Create() {
++count;
var html = "<tr>";
  html += "<td id='colOne" + count + "'>" + count + "</td>";
  // category
  html += "<td>"
    html += "<select class='form-control' id='colTwo" + count + "' name='colTwo[]' data-type='productCategory' required onchange='selectoption(this)'>";
      html += "<option value> --SELECT-- </option>"
      for (let i = 0; i < item_list.length; i++) {
      html += "<option value='" + item_list[i] + "'>" + item_list[i] + "</option>"
      }
    html += "</select>";
  html += "</td>";
  html += "<td><input type='text' class='form-control' data-type='productName'  id='colThree"+count+"' name='colThree[]' value='' tabindex='-1' /></td>";
  html += "<td><input type='text' class='form-control' data-type='productCode' value='" + count + "' id='colFour"+count+"' name='colFour[]' required /></td>" ;
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

function main() {
Create();
Create();
}
</script>
<?php
unset($_SESSION['ERROR']);
mysqli_close($conn);
?>