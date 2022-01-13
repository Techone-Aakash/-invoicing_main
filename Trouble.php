<?php
error_reporting(0);
session_start();
$hide_email = false;
$hide_otp = $hide_new_pass = true;
$_SESSION['email'] = $EMAIL = $OTP = $error ='';
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['Send'])) {
$EMAIL = $_POST['email'];
$email_search ="SELECT * FROM registration WHERE EMAIL = '$EMAIL' ";
$query = mysqli_query($conn, $email_search);
if (mysqli_num_rows($query)) {
$OTP = rand(100000,999999);
$_SESSION['code'] = $OTP;
$_SESSION['user'] = $EMAIL;

$subject = 'Otp for Reset Your password';

$body = '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
<title>OTP</title>
</head>
<style>
    *{
    margin:0;
    padding:0;
}
.container-fluid{
    margin:3% auto;    
    width: 75%;
    padding: 8px;
    box-shadow: 5px 10px 100px grey;
    border: 1px solid grey;
    border-radius: 15px;
}
.card{
    padding:0 10px;
    background-color:ghostwhite;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}
.card-header{
    font-size:2.5em;
    font-family:monospace;
    text-align: center;
    font-weight: 700;
    color:teal;
    padding: 5px;
    margin-bottom: 10px;
    border-bottom: 1px solid red;
}
.card-title{
    color: green;
    text-align: center;
    padding: 5px;
    border: 1px solid rebeccapurple;
}
.px-3{
    padding-left: 10px;
    font-family: cursive;

}
h2{
    color: black;
}
.card-footer{
    font-size:1rem;
    color: red;
    font-weight: 600;
    padding: 5px;
    margin-bottom: 5px;
    padding-left: 15px;
    border: 1px solid black ;
}
footer{
    background-color: ghostwhite;
    padding: 10px;
    border-top: 1px solid red;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}
</style>
<body>
<div class="container-fluid">
<div class="card">
    <div class="card-header h2 text-center text-info border-bottom border-danger p-2">
        Techone Aakash
    </div>
    <div class="card-body">
         <div class="card-title border text-center p-2 border-warning text-success"><b>One Time Password (OTP) sent from Techone Aakash For <h2 class="text-body">Reset Your Password</h2></b></div> 
            <div class="px-3"><br/>
        <div style="display:block;">This One Time Password (OTP) is Confidental.</br>
        Please do not share it with Anyone...</div></br>
         Your One Time Pasword is '.$OTP.'</div></br>
    </div>
    <div class="mx-3 card-footer text-danger border border-dark ">
        This is an System Generated mail, Please Do Not Reply Over This.
    </div><br/>
                    
</div>
<footer style="background-color:ghostwhite;">
    <div class="px-4">
        <div style="display:block; font-weight:600;">
            <div >Copyright &copy; Techone Aakash</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</body>
</html>';

$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

if(mail($EMAIL, $subject, $body, $headers)){
$error = "<p class='regis_error' style='color:green;'>OTP has been successfully sent to ".$EMAIL.".</p>";
$hide_email = true;
$hide_otp = false;
}else {
$error = "<p class='regis_error'>Sorry..! We are unable to send mail right now, Check Back Later...</p>";
}
}
else{
$error = "<p class='regis_error'>Email ID not Exist...</p>";
}
}
if (isset($_POST['Verify'])) {
$code = $_POST['otp'];
$hide_email = true;
if ($code == $_SESSION['code']) {
$hide_new_pass = false;
}else {
$error = "<p class='regis_error'>Invalid OTP Check AGAIN :)";
    $hide_otp = false;
    }
    }
    if (isset($_POST["Reset"])) {
    $pass = mysqli_real_escape_string($conn, $_POST["new_pass"]);
    $cpass = mysqli_real_escape_string($conn, $_POST["cnf_pass"]);
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);
    if (empty($_POST["new_pass"]) || empty($_POST["cnf_pass"])) {
    $error = "<p class='regis_error'>Both Fields are required</p>";
    $hide_email = true;
    $hide_otp = true;
    $hide_new_pass =FALSE;
    }elseif ($pass != $cpass) {
    $error = "<p class='regis_error'>New password and Confirm Password Must Be Same</p>";
    $hide_email = true;
    $hide_otp = true;
    $hide_new_pass =FALSE;
    }elseif(!$uppercase || !$lowercase || !$number){
    $hide_email = true;
    $hide_otp = true;
    $hide_new_pass = false;
    $error = "<p class='regis_error'>Try a mix of Capital, Small letters and Numbers.</p>";
    }elseif(strlen($pass) < 8 || strlen($pass) > 15 ){
    $error = "<p class='regis_error'>Password must be in 8-15 characters</p>";
    $hide_email = true;
    $hide_otp = true;
    $hide_new_pass =FALSE;
    }else{
    $EMAIL = $_SESSION['user'];
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    $sql = "UPDATE registration SET _PASSWORD = '$pass' WHERE EMAIL = '$EMAIL' ";
    if(mysqli_query($conn, $sql)){
    $error = "Password has been Changed Successfully<br/>".$EMAIL;
    // echo '<meta http-equiv="refresh" content="0;url=Signin.php" />';
    $hide_email = true;
    $hide_otp = true;
    $hide_new_pass =true;
    session_unset();
    }else {
    $error = "<p class='regis_error'>Sorry..! We are unable to send mail right now, Check Back Later...</p>";
    $hide_email = true;
    $hide_otp = true;
    $hide_new_pass =FALSE;
    }
    }
    }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Forget_details</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
            <link href="favicon1.png" rel="icon" type="image/x-icon" />
        </head>
        
        <style>
        * {
        margin: 0px;
        padding: 0px;
        }
        body {
        background: linear-gradient(273deg, #95e2f3, #f2d39b);
        background-size: 400% 400%;
        -webkit-animation: grad1 14s ease infinite;
        animation: grad1 14s ease infinite;
        }
        @-webkit-keyframes grad1 {
        0%{background-position:0% 52%}
        50%{background-position:100% 49%}
        100%{background-position:0% 52%}
        }
        @keyframes grad1 {
        0%{background-position:0% 52%}
        50%{background-position:100% 49%}
        100%{background-position:0% 52%}
        }
        a {
        cursor: pointer;
        }
        a:hover {
        color: rgb(0, 55, 144);
        }
        
        .container {
        position: relative;
        height: 93vh;
        }
        
        .form_div {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        }
        
        #registration {
        background: url("https://66.media.tumblr.com/2f2c930b91c4e54eb4f37e3a5da7f91a/tumblr_olmalfsAGi1uzwgsuo1_400.gifv") no-repeat;
        background-size: cover;
        height: auto;
        width: 500px;
        padding-bottom: 30px;
        border: 2px solid grey;
        border-radius:5px;
        color:darkslategray;
        text-align: center;
        box-shadow: 3px 3px 30px #6c787c;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }
        
        label {
        display: block;
        letter-spacing: 3px;
        padding-top: 30px;
        text-align: center;
        }
        
        /* animation for the text to float up */
        
        label .reg_field {
        cursor: text;
        font-size: 13px;
        line-height: 20px;
        text-transform: uppercase;
        -moz-transform: translateY(-55px);
        -ms-transform: translateY(-55px);
        -webkit-transform: translateY(-55px);
        transform: translateY(-55px);
        transition: all 0.3s;
        }
        
        /* remove the input box styling */
        label input {
        background-color: transparent;
        border: 0;
        border-bottom: 2px solid #4A4A4A;
        color: black;
        font-size: 18px;
        letter-spacing: 1px;
        outline: 0;
        padding: 5px 20px;
        text-align: center;
        transition: all .3s;
        width: 250px;
        }
        
        /* once you click in the input the input width box animates */
        
        label input:focus {
        max-width: 100%;
        width: 280px;
        border-bottom: 2px solid #a51d1d;
        }
        
        /* the text floats up and turns white */
        
        label input:focus+.reg_field {
        color: #a51d1d;
        font-weight: 600;
        text-transform: capitalize;
        font-size: 12px;
        margin-top: 20px;
        }
        
        /* the text floats up during form validation */
        
        label input:focus+.reg_field {
        font-size: 13px;
        -moz-transform: translateY(-74px);
        -ms-transform: translateY(-74px);
        -webkit-transform: translateY(-74px);
        transform: translateY(-74px);
        }
        
        /* button styling */
        
        input[type="submit"] {
        background: transparent;
        margin: auto;
        border: 2px solid gray;
        font-size: 15px;
        letter-spacing: 2px;
        padding: 20px 75px;
        text-transform: uppercase;
        cursor: pointer;
        display: inline-block;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
        }
        
        input~label:hover,
        input~.reg_field:hover {
        background-color: transparent;
        color: #a51d1d;
        }
        
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 2px solid #a51d1d;
        }
        
        .genderdiv {
        margin: 5px;
        letter-spacing: 2.5px;
        color: 333333;
        font-size: 1.1rem;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        display: inline;
        cursor: pointer;
        }
        
        .fa {
        position: absolute;
        }
        .fa-eye {
        z-index: 2;
        margin-left: 280px;
        background-color: transparent;
        font-size: 1.4em;
        cursor: pointer;
        border: 0;
        }
        .regis_error{
        letter-spacing: 1.5px;
        color:red;
        text-transform:none;
        font-weight:bold;
        }
        .footer{
        background:rgb(255, 255, 255);
        height: 7vh;
        max-height: 10vh;
        color:grey;
        font-size:.9rem;
        padding:0 20px;
        }
        
        @media only screen and (max-width:318px) {
        #registration {
        width: 270px;
        padding-bottom: 20px;
        border-radius:5px;
        }
        form h2{
        font-size: medium;
        }
        label .reg_field {
        font-size: 12px;
        
        }
        label input {
        border-bottom: 1.2px solid #4A4A4A;
        font-size: 15px;
        padding: 2px 5px;
        width: 210px;
        }
        
        label input:focus {
        max-width: 100%;
        width: 230px;
        border-bottom: 1.2px solid #a51d1d;
        }
        
        label input:focus+.reg_field {
        margin-top: 30px;
        }
        input[type="submit"] {
        border: 1.2px solid gray;
        font-size: 14px;
        padding: 15px 45px;
        }
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 1.2px solid #a51d1d;
        }
        
        .genderdiv {
        padding-top: 15px;
        letter-spacing:0;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        letter-spacing:0;
        }
        .fa-eye {
        margin-left: 205px;
        font-size: 1em;
        }
        .regis_error{
        letter-spacing: .3px;
        }
        .footer {
        padding: 0 5px;
        }
        .footer div{
        line-height: 45px;
        font-size:.55rem;
        }
        }
        
        @media only screen and (min-width:318px) and (max-width:350px) {
        #registration {
        width: 270px;
        padding-bottom: 20px;
        border-radius:5px;
        }
        form h2{
        font-size: medium;
        }
        label .reg_field {
        font-size: 12.5px;
        }
        label input {
        border-bottom: 1.2px solid #4A4A4A;
        font-size: 15px;
        padding: 2px 5px;
        width: 210px;
        }
        
        label input:focus {
        max-width: 100%;
        width: 230px;
        border-bottom: 1.2px solid #a51d1d;
        }
        
        label input:focus+.reg_field {
        margin-top: 30px;
        }
        input[type="submit"] {
        border: 1.2px solid gray;
        font-size: 14px;
        padding: 15px 45px;
        }
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 1.2px solid #a51d1d;
        }
        
        .genderdiv {
        letter-spacing:0;
        margin-top: -15px;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        letter-spacing:0;
        }
        .fa-eye {
        margin-left: 210px;
        font-size: 1em;
        }
        .regis_error{
        letter-spacing: .3px;
        }
        .footer div{
        line-height: 40px;
        font-size:.55rem;
        }
        }
        
        @media only screen and (min-width: 351px) and (max-width: 370px) {
        
        #registration {
        width: 290px;
        border-radius:10px;
        }
        form h2{
        font-size: medium;
        }
        label .reg_field {
        font-size: 13px;
        }
        label input {
        border-bottom: 1.2px solid #4A4A4A;
        font-size: 15px;
        padding: 2px 5px;
        width: 210px;
        }
        
        label input:focus {
        max-width: 100%;
        width: 230px;
        border-bottom: 1.2px solid #a51d1d;
        }
        
        label input:focus+.reg_field {
        margin-top: 30px;
        }
        input[type="submit"] {
        border: 1.2px solid gray;
        font-size: 14px;
        padding: 15px 45px;
        }
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 1.2px solid #a51d1d;
        }
        
        .genderdiv {
        letter-spacing:0;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        margin-right:10px ;
        letter-spacing:0;
        }
        .fa-eye {
        margin-left: 210px;
        font-size: 1em;
        }
        .regis_error{
        letter-spacing: .5px;
        }
        .footer div{
        line-height: 40px;
        font-size:.65rem;
        }
        }
        @media only screen and (min-width: 371px) and (max-width:433px) {
        
        #registration {
        width: 320px;
        border-radius:7px;
        }
        form h2{
        font-size: 1.2em;
        }
        label .reg_field {
        font-size: 13px;
        line-height:25px;
        }
        label input {
        border-bottom: 1.4px solid #4A4A4A;
        font-size: 15px;
        padding: 2px 5px;
        width: 230px;
        }
        
        label input:focus {
        max-width: 100%;
        width: 250px;
        border-bottom: 1.4px solid #a51d1d;
        }
        
        label input:focus+.reg_field {
        margin-top: 25px;
        }
        input[type="submit"] {
        border: 1.2px solid gray;
        font-size: 14px;
        padding: 15px 45px;
        }
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 1.2px solid #a51d1d;
        }
        
        .genderdiv {
        letter-spacing:0;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        margin-right:10px ;
        letter-spacing:0;
        }
        .fa-eye {
        margin-left: 230px;
        font-size: 1em;
        }
        .regis_error{
        letter-spacing: 1px;
        }
        .footer div{
        line-height: 55px;
        font-size:.70rem;
        }
        }
        @media only screen and (min-width: 434px) and (max-width:500px) {
        #registration {
        width: 350px;
        border-radius:7px;
        }
        form h2{
        font-size: 1.25em;
        }
        label .reg_field {
        font-size: 14px;
        line-height:22px;
        }
        label input {
        border-bottom: 1.4px solid #4A4A4A;
        font-size: 15px;
        padding: 2px 5px;
        width: 230px;
        }
        
        label input:focus {
        max-width: 100%;
        width: 250px;
        border-bottom: 1.4px solid #a51d1d;
        }
        
        label input:focus+.reg_field {
        margin-top: 25px;
        }
        input[type="submit"] {
        border: 1.2px solid gray;
        font-size: 14px;
        padding: 15px 45px;
        }
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 1.2px solid #a51d1d;
        }
        
        .genderdiv {
        letter-spacing:0;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        margin-right:10px ;
        letter-spacing:1px;
        }
        .fa-eye {
        margin-left: 230px;
        font-size: 1em;
        }
        .regis_error{
        letter-spacing: 1.3px;
        }
        .footer div{
        line-height: 50px;
        font-size:.80rem;
        }
        }
        
        @media screen and (min-width:501px) and (max-width: 599px) {
        
        #registration {
        width: 400px;
        border-radius:6px;
        }
        form h2{
        font-size: 1.3em;
        }
        label .reg_field {
        font-size: 15px;
        line-height:22px;
        }
        label input {
        border-bottom: 1.4px solid #4A4A4A;
        font-size: 15px;
        padding: 2px 5px;
        width: 230px;
        }
        
        label input:focus {
        max-width: 100%;
        width: 250px;
        border-bottom: 1.4px solid #a51d1d;
        }
        
        label input:focus+.reg_field {
        margin-top: 25px;
        }
        input[type="submit"] {
        border: 1.5px solid gray;
        font-size: 15px;
        padding: 15px 45px;
        }
        input[type="submit"]:hover {
        background:rgba(47, 79, 79, 0.082);
        border: 1.5px solid #a51d1d;
        }
        .genderdiv {
        letter-spacing:0;
        }
        label[for="male"],
        [for="female"],
        [for="other"] {
        margin-right:15px ;
        letter-spacing:2px;
        }
        .fa-eye {
        margin-left: 250px;
        font-size: 1em;
        }
        .regis_error{
        letter-spacing: 1.5px;
        }
        .footer div{
        line-height: 50px;
        font-size:.85rem;
        }
        }
        @media screen and (min-width:600px) and (max-width: 699px) {
        .footer div{
        line-height: 50px;
        font-size:.85rem;
        }
        }
        
        </style>
        <body>
            <div class="container">
                <div class="form_div">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="registration" method="POST">
                        <h2 style="width:100%;text-decoration:underline; text-transform:uppercase; letter-spacing:4px; text-decoration:underline; color: #a51d1d; padding:35px 0;">
                        Reset Password</h2>
                        <?php if($hide_email == false){  ?>
                        <label><i class="fa fa-envelope" aria-hidden="true"></i>
                            <input type="Email" name="email"  autocomplete="off" />
                            <div class="reg_field">
                                <?php
                                if ($error != "") {
                                echo $error;
                                }else {
                                echo "Enter Email Id";
                                } ?>
                            </div>
                        </label><br>
                        <input type="submit" name="Send" value="Send Otp" />
                        <?php   } ?>
                        <?php if($hide_otp == false){    ?>
                        <label><i class="fa fa-lock" aria-hidden="true"></i>
                            <input type="tel" maxlength="6" name="otp" autocomplete="off" />
                            <div class="reg_field">
                                <?php
                                if ($error != "") {
                                echo $error;
                                }else {
                                echo "Enter Valid OTP";
                                } ?>
                            </div>
                        </label><br/>
                        <input type="submit" name="Verify" value="Verify" />
                        <?php   } ?>
                        <?php if($hide_new_pass == false){    ?>
                        <label><i class="fa fa-lock" aria-hidden="true"></i>
                            <i onclick="pwdShow();" class="fa fa-eye" aria-hidden="true"></i>
                            <input type="password" minlength="8" maxlength="20" name="new_pass" required autocomplete="off" id="password" />
                            <div class="reg_field">
                                <?php
                                if ($error != "") {
                                echo $error;
                                }else {
                                echo "New Password";
                                } ?>
                            </div>
                        </label><br>
                        <label><i class="fa fa-lock" aria-hidden="true"></i>
                            <i onclick="cpwdShow();" class="fa fa-eye" aria-hidden="true"></i>
                            <input type="password" minlength="8" maxlength="20" name="cnf_pass" required autocomplete="off" id="cpassword" />
                            <div class="reg_field">
                                <?php
                                if ($error != "") {
                                echo $error;
                                }else {
                                echo "Confirm Password";
                                } ?>
                            </div>
                            </labe><br>
                            <input type="submit" name="Reset" value="Reset" />
                            <?php   } ?>
                            <?php if(!$hide_email == FALSE && !$hide_otp == FALSE && !$hide_new_pass == FALSE){
                            echo "<h3 class='regis_error' style='color:green;'>".$error."</h3>";
                            echo "<br><br><h4>Login Again  <a href='Login.php'>Click here..</a></h4>";
                            }
                            mysqli_close($conn);
                            ?>
                        </form>
                    </div>
                </div>
                <footer class="footer">
                    <div style="line-height: 65px; font-weight:600; ">
                        <div style="float: left;">Copyright &copy; Techone Aakash</div>
                        <div style="float: right;">
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </footer>
            </body>
            <script>
            function pwdShow() {
            let x = document.getElementById("password");
            if (x.type === "password") {
            x.type = "text";
            } else {
            x.type = "password";
            }
            }
            function cpwdShow() {
            let x = document.getElementById("cpassword");
            if (x.type === "password") {
            x.type = "text";
            } else {
            x.type = "password";
            }
            }
            </script>
        </html>