<?php
error_reporting(0);
$USERNAME = $C_PASSWORD = $EMAIL = $PASSWORD = $GENDER = $OTP = $user_error = $email_error = $cpass_error = $pass_error = $gender_error = "";
include "connect.php";
$V_STATUS = "FALSE";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$USERNAME = mysqli_real_escape_string($conn, $_POST["username"]);
$EMAIL = mysqli_real_escape_string($conn, $_POST["email"]);
$C_PASSWORD = mysqli_real_escape_string($conn, $_POST["cnf_password"]);
$PASSWORD = mysqli_real_escape_string($conn, $_POST["password"]);
$GENDER = mysqli_real_escape_string($conn, $_POST["gender"]);
if (empty($_POST["username"])) {
$user_error = "Usename is required";
}else {
$uppercase = preg_match('@[A-Z]@', $USERNAME);
$lowercase = preg_match('@[a-z]@', $USERNAME);
$number    = preg_match('@[0-9]@', $USERNAME);
if(!$uppercase || !$lowercase || !$number){
$user_error = "Try a mix of Capital, Small letters and Numbers.";
}
if(strlen($USERNAME) < 6 || strlen($USERNAME) > 15 ){
$user_error ="Username must be in 6-15 characters";
}
$sql_user = "SELECT * FROM registration WHERE USERNAME='$USERNAME'";
$res_user = mysqli_query($conn, $sql_user);
if (mysqli_num_rows($res_user) > 0) {
$user_error = "Sorry... username already taken";
}
}
if (empty($_POST["email"])) {
$email_error = "Email is required";
} else {
if (!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) {
$email_error = "Invalid email format";
}
$sql_email = "SELECT * FROM registration WHERE EMAIL='$EMAIL'";
$res_email = mysqli_query($conn, $sql_email);
if (mysqli_num_rows($res_email) > 0) {
$email_error = "Sorry... email already taken";
}
}
// if (empty($_POST["phone"])) {
//         $cpass_error = "Mobile no is required";
// } else {
//         if (!preg_match ("/^[0-9]*$/", $PHONE) ) {
//         $cpass_error = "Only numeric value is allowed.";
//         }
//         if (strlen ($PHONE) != 10) {
//         $cpass_error = "Mobile no. must contain 10 digits.";
//         }
//         $sql_phone = "SELECT * FROM registration WHERE PHONE='$PHONE'";
//         $res_phone = mysqli_query($conn, $sql_phone);
//         if (mysqli_num_rows($res_phone) > 0) {
//         $cpass_error = "Sorry... phone number already taken";
//         }
// }
if (empty($_POST["password"])) {
$pass_error = "Password is required";
} else {
$uppercase = preg_match('@[A-Z]@', $PASSWORD);
$lowercase = preg_match('@[a-z]@', $PASSWORD);
$number    = preg_match('@[0-9]@', $PASSWORD);
if(!$uppercase || !$lowercase || !$number){
$pass_error = "Try a mix of Capital, Small letters and Numbers.";
}
if(strlen($PASSWORD) < 8 || strlen($PASSWORD) > 15 ){
$pass_error ="Password must be in 8-15 characters";
}else{
if($PASSWORD === $C_PASSWORD){
$PASSWORD = password_hash($PASSWORD, PASSWORD_BCRYPT);
}else{
$cpass_error ="Password & Confirm Password Must be Same.";
}
}
}
if (empty ($_POST["gender"])) {
$gender_error = "Gender is required";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register...</title>
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
    }            a {
    text-decoration: none;
    cursor: pointer;
    }
    a:hover {
    color: rgb(0, 55, 144);
    }
    
    .container {
    position: relative;
    height: 99vh;
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
    input[type="radio"]{
    margin-right: 2px;
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
    
    @media only screen and (max-width:318px) {
    #registration {
    width: 270px;
    padding-bottom: 20px;
    border-radius:15px;
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
    }
    
    @media only screen and (min-width:318px) and (max-width:350px) {
    #registration {
    width: 270px;
    padding-bottom: 20px;
    border-radius:15.5px;
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
    }
    @media only screen and (min-width: 371px) and (max-width:433px) {
    
    #registration {
    width: 320px;
    border-radius:10px;
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
    }
    @media only screen and (min-width: 434px) and (max-width:500px) {
    #registration {
    width: 350px;
    border-radius:8px;
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
    }
    </style>
    <body>
        <div class="container">
            <div class="form_div">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="registration" method="POST">
                    <h2
                    style="width:100%;text-decoration:underline; text-transform:uppercase; letter-spacing:4px; text-decoration:underline; color: #a51d1d; padding:35px 0;">
                    registration form</h2>
                    <label><i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" name="username" required autocomplete="off" />
                        <div class="reg_field">
                            <?php
                            if ($user_error != "") {
                            echo "<p class='regis_error'>$user_error</p>";
                            }else {
                            echo "Username";
                            } ?>
                        </div>
                    </label>
                    <label><i class="fa fa-envelope" aria-hidden="true"></i>
                        <input type="Email" name="email" required autocomplete="off"/>
                        <div class="reg_field">
                            <?php
                            if ($email_error != "") {
                            echo "<p class='regis_error'>$email_error</p>";
                            }else {
                            echo "Email Id";
                            } ?>
                        </div>
                    </label>
                    <label><i class="fa fa-key" aria-hidden="true"></i>
                        <i onclick="pwdShow();" class="fa fa-eye" aria-hidden="true"></i>
                        <input type="password" name="password" id="password" required autocomplete="off" maxlength="15" />
                        <div class="reg_field">
                            <?php
                            if ($pass_error != "") {
                            echo "<p class='regis_error'>$pass_error</p>";
                            }else {
                            echo "Password";
                            } ?>
                        </div>
                    </label>
                    <label><i class="fa fa-key" aria-hidden="true"></i>
                        <i onclick="cpwdShow();" class="fa fa-eye" aria-hidden="true"></i>
                        <input type="password" name="cnf_password" id="cpassword" maxlength="15" required autocomplete="off" />
                        <div class="reg_field">
                            <?php
                            if ($cpass_error != "") {
                            echo "<p class='regis_error'>$cpass_error</p>";
                            }else {
                            echo "Confirm Password";
                            } ?>
                        </div>
                    </label>
                    <div class="genderdiv">
                        <?php
                        if ($gender_error != "") {
                        echo "<p class='regis_error' style='font-size: 0.7em;'>$gender_error</p><br>";
                        }else {
                        echo "Gender :";
                        } ?>
                        <input type="radio" id="male" value="Male" name="gender" checked ><label for="male">Male</label>
                        <input type="radio" id="female" value="Female" name="gender"><label for="female">Female</label>
                        <input type="radio" id="other" value="Other" name="gender"><label for="other">Other</label>
                    </div><br>
                    <input type="submit" name="Submit" value="Submit" />
                </form>
            </div>
        </div>
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
    </body>
</html>
<?php
if ($user_error == "" && $cpass_error == "" && $email_error == "" && $gender_error == "" && $pass_error == "") {
if(isset($_POST["Submit"])){
$sql = "INSERT INTO registration (USERNAME, EMAIL, _PASSWORD, GENDER, V_STATUS) VALUES ( '$USERNAME', '$EMAIL', '$PASSWORD', '$GENDER' , '$V_STATUS')";
if(mysqli_query($conn, $sql)){
//   echo '<meta http-equiv="refresh" content="0;url=Login.php" />';

header("location:login.php");

}
else{
echo "not inserted";
}
mysqli_close($conn);
}
}
?>