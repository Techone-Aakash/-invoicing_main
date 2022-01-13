<?php
                session_start();
                error_reporting(0);
                if(!isset($_SESSION["USERNAME"])){
                header("location:login.php");
                exit();
                }else{
                include 'header.php';
                include 'connect.php';
                $sql = "SELECT USERNAME from profile where USERNAME = '".$_SESSION["USERNAME"]."'  ";
                $res = mysqli_query($conn,$sql);

                if(mysqli_num_rows($res) > 0){
                $_SESSION['profile_exist'] = true;
                }else{
                $_SESSION['profile_exist'] = false;
                }
                mysqli_free_result($res);
                }
                $var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14=$var15=$var16=$var17=$var18=$var19=$var20=$var21=$var22="";

                $var1 = mysqli_real_escape_string($conn,$_POST["var1"]);
                $var2 = mysqli_real_escape_string($conn,$_POST["var2"]);
                $var3 = mysqli_real_escape_string($conn,$_POST["var3"]);
                $var4 = mysqli_real_escape_string($conn,$_POST["var4"]);
                $var5 = mysqli_real_escape_string($conn,$_POST["var5"]);
                $var6 = mysqli_real_escape_string($conn,$_POST["var6"]);
                $var7 = mysqli_real_escape_string($conn,$_POST["var7"]);
                $var8 = mysqli_real_escape_string($conn,$_POST["var8"]);
                $var9 = mysqli_real_escape_string($conn,$_POST["var9"]);
                $var10 = mysqli_real_escape_string($conn,$_POST["var10"]);
                $var11 = mysqli_real_escape_string($conn,$_POST["var11"]);
                $var12 = mysqli_real_escape_string($conn,$_POST["var12"]);
              //  $var13 = mysqli_real_escape_string($conn,$_POST["var13"]);
                $var14 = mysqli_real_escape_string($conn,$_POST["var14"]);
                $var15 = mysqli_real_escape_string($conn,$_POST["var15"]);
                $var16 = mysqli_real_escape_string($conn,$_POST["var16"]);
                $var17 = mysqli_real_escape_string($conn,$_POST["var17"]);
                $var18 = mysqli_real_escape_string($conn,$_POST["var18"]);
                $cnf_var18 = mysqli_real_escape_string($conn,$_POST["cnf_var18"]);
                $var19 = mysqli_real_escape_string($conn,$_POST["var19"]);
                $var20 = mysqli_real_escape_string($conn,$_POST["var20"]);
                $var21 = mysqli_real_escape_string($conn,$_POST["var21"]);
                $var22 = mysqli_real_escape_string($conn,$_POST["var22"]);


                if($var18 == $cnf_var18){
                    $flag_cnf_var18 = true;
                }else{
                    $flag_cnf_var18 = false;
                    $ac_no_er = "Retype Account Number Must Be Same";
                }

                $sql = "SELECT EMAIL from registration where USERNAME = '".$_SESSION["USERNAME"]."'  ";
                if($res = mysqli_query($conn,$sql)){
                    $reg_row = mysqli_fetch_assoc($res); 
                    $email = $reg_row["EMAIL"];
                    mysqli_free_result($res);
                }


                if ($_SERVER["REQUEST_METHOD"] == "POST"  && (isset($_POST["Submit"])) && $_SESSION["profile_exist"] == false) {

                include 'filecheck.php';
                if(!isset($file_error) && $flag_cnf_var18 == true){

                $sql = "INSERT INTO profile(USERNAME, First_n, Middle_n, Last_n, Address1, Address2, Zip, City, _State, Comp_n, Email, Gst, Pan, Moto, Logo_Path  , Ph1, Ph2, Category , Ac_n, Ac_no, Ac_ifsc, Terms1, Terms2, Terms3) VALUES ( '".$_SESSION['USERNAME']."','$var1','$var2','$var3','$var4','$var5','$var6','$var7','$var8','$var9','$email','$var10','$var11','$var12','$original_file','$var14','$var15','$var16','$var17','$var18','$var19','$var20','$var21','$var22')";
                if(mysqli_query($conn,$sql)){
                header("location:profile.php");
                }else{
                echo "Sorry";
                }
            }
        }
                    //$profile_exist_edit = false;

           if ($_SERVER["REQUEST_METHOD"] == "POST"  && (isset($_POST["Edit"])) ) {
                $profile_exist_edit = true;
                }

           if ($_SERVER["REQUEST_METHOD"] == "POST"  && (isset($_POST["Resubmit"])) && $_SESSION["profile_exist"] == true){
                include 'filecheck.php';

                if(!isset($file_error) && $flag_cnf_var18 == true){
                if($original_file == ""){
                //  echo '<br><br><br><br>'.explode('.', $var13));

                $sql = "UPDATE profile SET First_n = '$var1', Middle_n = '$var2', Last_n = '$var3', Address1 = '$var4', Address2 = '$var5', Zip = '$var6', City = '$var7', _State = '$var8', Comp_n = '$var9', Gst = '$var10', Pan = '$var11', Moto = '$var12', Ph1 = '$var14', Ph2 = '$var15', Category = '$var16', Ac_n = '$var17', Ac_no = '$var18', Ac_ifsc = '$var19', Terms1 = '$var20', Terms2 = '$var21', Terms3 = '$var22' WHERE USERNAME = '".$_SESSION['USERNAME']."' ";
                if(mysqli_query($conn,$sql)){
                header("location:profile.php");
                }else{
                header("location:500.html");
                }
                }else{
                $sql = "UPDATE profile SET First_n = '$var1', Middle_n = '$var2', Last_n = '$var3', Address1 = '$var4', Address2 = '$var5', Zip = '$var6', City = '$var7', _State = '$var8', Comp_n = '$var9', Gst = '$var10', Pan = '$var11', Moto = '$var12', Logo_Path = '$original_file', Ph1 = '$var14', Ph2 = '$var15', Category = '$var16', Ac_n = '$var17', Ac_no = '$var18', Ac_ifsc = '$var19', Terms1 = '$var20', Terms2 = '$var21', Terms3 = '$var22' WHERE USERNAME = '".$_SESSION['USERNAME']."' ";
                if(mysqli_query($conn,$sql)){
                header("location:profile.php");
                }else{
                header("location:500.html");
                }
                }
                }
            }
?>

<title>Profile - <?php echo $_SESSION['USERNAME'];?></title>
</head>
<?php include 'sidenav.php'; ?>
<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
        
        <?php if ($_SESSION['profile_exist'] == false) { ?>
        <form novalidate="" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
        enctype="multipart/form-data">
            
            <?php if(isset($_SESSION["ERROR"])){
            echo '<div class="d-flex px-2 my-3 py-1 alert-primary h5">'.$_SESSION["ERROR"].'</div>';
            } ?>
            <div class="d-flex px-2 my-3 py-1 alert-danger h5"><b class="px-1">*</b>Fields are Mandatory</div>
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Personal Details
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">First name<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="20" name="var1" name="var1" class="form-control" id="vali01" placeholder="First name" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali02">Middle name</label>
                            <input type="text" maxlength="20" name="var2" class="form-control" id="vali02" placeholder="Middle name">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali03">Last name<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="20" name="var3" class="form-control" id="vali03" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3 ">
                            <label for="vali04">Address (Line 1)<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="100" name="var4" class="form-control" id="vali04" placeholder="Street Address, P.O."  required>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3 ">
                            <label for="vali05">Address (Line 2)</label>
                            <input type="text" maxlength="100" name="var5" class="form-control" id="vali05" placeholder="Apartment, Suite, Unit, etc." >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="vali06">Zip/Pincode<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="6" name="var6" class="form-control" id="vali06" placeholder="Zip/Pincode" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali07">District<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="30" name="var7" class="form-control" id="vali07" placeholder="District" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali08">State<span class="mx-1 text-danger h5">*</span></label>
                            <select name="var8" id="vali08" class="form-control" required>
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
                </div>
            </div>
            
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Company Details
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-sm-8 mb-3">
                            <label for="vali09">Company name<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" name="var9" class="form-control" id="vali09" maxlength="50" placeholder="Company name"  required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali10">GSTIN</label>
                            <input type="text" maxlength="15" name="var10" class="form-control" id="vali10" placeholder="Gst no.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="vali11">PAN (Permanent Account Number)<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="10" name="var11" class="form-control" id="vali11" placeholder="Pan no. " required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali12">Your Company Moto</label>
                            <input type="text" maxlength="50" name="var12" class="form-control" id="vali12" placeholder="Shown in the top" >
                        </div>
                        <div class="col-sm-4 mb-3">
                                <?php 
                                if ($file_error != "") {
                                    echo '<label for="vali13" style="color:red;">'.$file_error.'</label>';
                                }else {
                                    echo  "<label for='vali13'> Logo (JPG/PNG/JPEG) > 500Kb</label>";
                                }
                                ?>
                            <input type="file"  name="var13" class="form-control" id="vali13" >
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-4 mb-3">
                            <label for="vali14">Phone no. 1<span class="mx-1 text-danger h5">*</span></label>
                            <input type="tel" maxlength="10"  name="var14" class="form-control" id="vali14" placeholder="Phone"  required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali15">Phone no. 2</label>
                            <input type="tel" maxlength="10"  name="var15" class="form-control" id="vali15" placeholder="Phone" >
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali16">Business Category<span class="mx-1 text-danger h5">*</span></label>
                            <select class="form-control" name="var16">
                              <option value="" required>-- SELECT --</option>
                              <?php $sql="SELECT category FROM item_table";
                              $result = mysqli_query($conn, $sql);
                              foreach ($result as $value) {
                              echo '<option value='.$value['category'].' >'.$value['category'].'</option>';
                              }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Payment Details
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col mb-3 ">
                            <label for="vali17">Account Name<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="40" name="var17" class="form-control" id="vali17" placeholder="Account Name"  required>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-4 mb-3">
                            <label for="vali18">Account Number<span class="mx-1 text-danger h5">*</span></label>
                            <input type="number" maxlength="20" class="form-control"  name="var18" id="vali18" placeholder="Account Number" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                                <?php
                                if($ac_no_er != ""){
                                     echo '<label for="vali19" class="text-danger">'.$ac_no_er.'</label>';
                                }else {
                                    echo  "<label for='vali19'>Retype Account Numbe<span class='mx-1 text-danger h5'>*</span></label>";
                                }
                                ?>
                            <input type="number" maxlength="20" class="form-control" id="vali19" placeholder="Retype Account Number" name="cnf_var18" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali20">IFS Code<span class="mx-1 text-danger h5">*</span></label>
                            <input type="text" maxlength="15" name="var19" class="form-control" id="vali20" placeholder="IFS Code" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                   Remarks (Shown in the Bottom)
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col mb-3 ">
                            <label for="vali21">Line 1</label>
                            <input type="text" maxlength="120" name="var20" class="form-control" id="vali21" placeholder="Line 1">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3 ">
                            <label for="vali22">Line 2</label>
                            <input type="text"  maxlength="120" name="var21" class="form-control" id="vali22" placeholder="Line 2">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3 ">
                            <label for="vali23">Line 3</label>
                            <input type="text"  maxlength="120" name="var22" class="form-control" id="vali23" placeholder="Line 3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                    <label class="form-check-label" for="invalidCheck2">
                        Agree to terms and conditions
                    </label>
                </div>
            </div>
            <button class="btn btn-primary mt-3 px-3" type="submit" name="Submit">Save Details</button>
        </form>


        <?php }else{
        $sql = "SELECT * From profile where USERNAME = '".$_SESSION['USERNAME']."' ";
        if($result = mysqli_query($conn,$sql)){
        $row = mysqli_fetch_assoc($result);
        }?>
        <form novalidate="" method= "POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <?php if($profile_exist_edit == true){
            echo '<div class="flex-row mb-3 py-1 px-2 alert-danger  h6">Mandatory Fields are marked with<span class="mx-1 h4 text-danger">*</span></div>';
            }else{
            echo '<div class="flex-row mb-4 h6 p-2 alert-success">Profile Has Been Updated Sucessfully...</div>';
            }?>
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Personal Details
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">First name<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var1' autocomplete='off' maxlength='20' ";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['First_n']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Middle name</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var2' autocomplete='off' maxlength='20' ";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Middle_n']; ?>">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Last name<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var3' autocomplete='off' maxlength='20' ";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Last_n']; ?>" required>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3">
                            <label for="vali01">Address 1<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var4' autocomplete='off' maxlength='100'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Address1']; ?>" required>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3">
                            <label for="vali01">Address 2</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var5' autocomplete='off' maxlength='100'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Address2']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Zip/Pincode<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var6' autocomplete='off' maxlength='6'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Zip']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">District<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var7' autocomplete='off' maxlength='30'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['City']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">State<span class="mx-1 text-danger h5">*</span></label>

                          <?php if($profile_exist_edit != true) {?>

                            <input class="form-control" value="<?php echo $row['_State']; ?>" readonly />
                          
                          <?php }else{ echo '<select class="form-control" name="var8" required>'; ?>

                                <option value="<?php echo $row['_State']; ?>"><?php echo $row['_State']; ?></option>
                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                <option value="Arunachal Pradesh" >Arunachal Pradesh</option>
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
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Company Details
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-sm-8 mb-3">
                            <label for="vali01">Company name<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var9' autocomplete='off' maxlength='50'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Comp_n']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">GSTIN</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var10' autocomplete='off' maxlength='15'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Gst']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">PAN (Permanent Account Number)<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var11' autocomplete='off' maxlength='10'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Pan']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Your Company Moto</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var12' autocomplete='off' maxlength='50'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Moto']; ?>">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <?php 
                                if ($file_error != "") {
                                    echo '<label for="vali13" style="color:red;">'.$file_error.'</label>';
                                }else {
                                    echo  "<label for='vali13'> Logo (JPG/PNG/JPEG) > 500Kb</label>";
                                }
                            ?>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var13' type='file' autocomplete='off' ";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Logo_Path']; ?>">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Phone no. 1<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var14' autocomplete='off' maxlength='10'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Ph1']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Phone no. 2</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var15' autocomplete='off' maxlength='10'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Ph2']; ?>">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Business Category<span class="mx-1 text-danger h5">*</span></label>


                            <select class="form-control" <?php if($profile_exist_edit == true) {
                            echo "name='var16' autocomplete='off' maxlength='50' required >";
                             echo '<option value='.$row['Category'].'>'.$row['Category'].'</option>';        
                             $sql="SELECT category FROM item_table";
                              $result = mysqli_query($conn, $sql);
                              foreach ($result as $value) {
                              echo '<option value='.$value['category'].' >'.$value['category'].'</option>';
                              };
                            }else{echo 'disabled >';
                             echo '<option value="'.$row['Category'].'">'.$row['Category'].'</option>';
                            } ?>
                            </select>

<!--                             <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var16' autocomplete='off' maxlength='50'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Category']; ?>" required> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Payment Details
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col mb-3">
                            <label for="vali01">Account Name<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var17' autocomplete='off' maxlength='20'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Ac_n']; ?>" required>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">Account Number<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var18' autocomplete='off' maxlength='20'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Ac_no']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                                <?php
                                if($ac_no_er != ""){
                                     echo '<label for="vali19" class="text-danger">'.$ac_no_er.'</label>';
                                }else {
                                    echo  "<label for='vali19'>Retype Account Numbe<span class='mx-1 text-danger h5'>*</span></label>";
                                }
                                ?>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "autocomplete='off' maxlength='20'
                             name='cnf_var18'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Ac_no']; ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="vali01">IFS Code<span class="mx-1 text-danger h5">*</span></label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var19' autocomplete='off' maxlength='15'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Ac_ifsc']; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 bg-transparent">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                   Remarks (Shown in the Bottom)
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col mb-3">
                            <label for="vali01">Line 1</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var20' autocomplete='off' maxlength='120'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Terms1']; ?>">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3">
                            <label for="vali01">Line 2</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var21' autocomplete='off' maxlength='120'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Terms2']; ?>">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col mb-3">
                            <label for="vali01">Line 3</label>
                            <input class="form-control"
                            <?php if($profile_exist_edit == true) {
                            echo "name='var22' autocomplete='off' maxlength='120'";
                            }else{echo 'disabled';} ?>
                            value="<?php echo $row['Terms3']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center"><button type="submit"
                <?php if($profile_exist_edit == true) {
                echo "class='btn btn-danger px-3' name='Resubmit'>Save Details";
                }else{echo "class='btn btn-success px-3' name='Edit'>Edit Details";} ?>
                
            </button></div>
        </form>
        <style>
        .form-control{
        text-align: center;
        }
        </style>
        <?php } ?>
    </div>
</main>
<?php
include 'footer.php';
unset($_SESSION['ERROR']);
mysqli_close($conn);
?>