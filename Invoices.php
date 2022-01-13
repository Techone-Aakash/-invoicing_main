<?php
session_start();
error_reporting(0);
include 'connect.php';
unset($_SESSION['id']);
if(!isset($_SESSION["USERNAME"])){
    header("location:login.php");
    exit();
   }
   include 'header.php';
?>

        <title>Invoices - <?php echo $_SESSION['USERNAME'];?></title>
    </head>
             <?php include 'sidenav.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Invoices</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Invoices</li>
                        </ol>
                        
                        <?php
                        if(isset($_SESSION['ERROR'])){ 
                            echo '<div><p class="p-2 alert-danger h6">'.$_SESSION['ERROR'].'</p></div>';
                        } ?>
                     
                        <div class="card mb-4 bg-transparent">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Invoices 
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead class="card-header text-center pr-2'">
                                        <tr>
                                            <th class='text-center px-2'>Invoice Id</th>
                                            <th class='text-center px-2'>Name</th>
                                            <th class='text-center px-2'>Address</th>
                                            <th class='text-center px-2'>Payment Status</th>
                                            <th class='text-center px-2'>Date</th>
                                            <th class='text-center px-2'>Amount</th>
                                            <th class='text-center px-2' colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM customers_data WHERE total_sc_gst!=0.00 AND USERNAME ='".$_SESSION["USERNAME"]."' ";
                                        if($result = mysqli_query($conn,$sql)){
                                        for($i=1; $i<=mysqli_num_rows($result); $i++){
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                        <tr>
                                        <td class='text-center px-2'><?php echo $row["INVOICE_ID"] ; ?></td>
                                        <td class='text-center px-2'><?php echo $row["_NAME"] ; ?></td>
                                        <td class='text-center px-2'><?php echo $row["_ADDRESS"] ; ?></td>
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

                                        <td class='text-center px-2'><?php echo date("d/m/y", strtotime($row["_DATE"])) ;?></td>
                                        <td class='text-center px-2'><?php echo $row["grand_total"] ; ?></td>

                                    <?php if ($row["MODE"] != "Cancelled"){ ?>

                                        <td class='text-center px-2'><a href='print_invoice.php?id=<?php echo $row["id"];?>' class="text-decoration-none"><input type="hidden" name="id" value=$id><i class="fa fa-print text-primary mx-1"></i>Print</a></td>                                   

                                        <td class='text-center px-2'><a href='Edit_invoice.php?id=<?php echo $row["id"];?>' class="text-decoration-none"><input type="hidden" name="id" value=$id alt="print"><i class="fa fa fa-edit text-success mx-1" ></i>Edit</a></td>
                                        
                                        <td class='text-center px-2'><a href='Delete_Invoice.php?id=<?php echo $row["id"];?>' class="text-decoration-none" onclick="return confirm('Would you want to delete this?');"><input type="hidden" name="id" value=$id><i class="fa fa-times text-danger mx-1"></i>Cancel</a></td>
                                    <?php }else{ ?>

                                        <td colspan="3" class='text-center px-2'><a href='print_invoice.php?id=<?php echo $row["id"];?>' class="text-decoration-none"><input type="hidden" name="id" value=$id><i class="fa fa-print text-primary mx-1"></i>Print</a></td>

                                   <?php } ?>
                                    </tr>
                                    <?php
                                    }mysqli_free_result($result);
                                    } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
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
<?php
unset($_SESSION['ERROR']);
mysqli_close($conn);
?>