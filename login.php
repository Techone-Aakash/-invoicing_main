<?php
error_reporting(0);
session_start();
$USERNAME = $PASSWORD = $error ="";
include "connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["Submit"])) ) {
$USERNAME = mysqli_real_escape_string($conn, $_POST["user"]);
$PASSWORD = mysqli_real_escape_string($conn, $_POST["pass"]);
$email_search ="SELECT * FROM registration WHERE USERNAME = '$USERNAME' or EMAIL ='$USERNAME' ";
$query = mysqli_query($conn, $email_search);
$email_count = mysqli_num_rows($query);
if (!$email_count == 0) {
$row_value = mysqli_fetch_assoc($query);
$db_pass = $row_value['_PASSWORD'];
$USERNAME = $row_value['USERNAME'];
$pass_decode = password_verify($PASSWORD, $db_pass);
if ($pass_decode) {
$_SESSION['USERNAME'] = $USERNAME;
header("location:index.php");
} else {
$error = "Wrong Password";
}
} else {
$error = "Wrong Username";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
            <link href="favicon1.png" rel="icon" type="image/x-icon" />
            <title>Sign-in</title>
        </head>
        <style>
        * {
        margin: 0px;
        padding: 0px;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial,sans-serif;
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
        
        form {
        background: url("https://66.media.tumblr.com/2f2c930b91c4e54eb4f37e3a5da7f91a/tumblr_olmalfsAGi1uzwgsuo1_400.gifv") no-repeat;
        background-size: cover;
        height: 360px;
        width: 610px;
        border-radius: 10px;
        border: ridge 1.5px black;
        border-top-left-radius: 40px;
        border-bottom-right-radius: 40px;
        box-shadow: 5px 10px 60px rgba(53, 46, 46, 0.63);
        }
        .social-login {
        text-align: center;
        text-decoration: underline;
        font-size: 1.2em;
        color: rgb(1, 36, 93);
        font-weight: 600;
        font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        letter-spacing:1.5px;
        }
        
        .logo-div {
        background: url("https://66.media.tumblr.com/2f2c930b91c4e54eb4f37e3a5da7f91a/tumblr_olmalfsAGi1uzwgsuo1_400.gifv") no-repeat;
        background-size: cover;
        margin: -40px 79.5% 0 5%;
        transform: rotate(45deg);
        border-bottom: 2px solid rgb(0, 72, 90);
        border-right: 2px solid rgb(0, 72, 90);
        border-radius: 50%;
        padding: 20px 0;
        text-align: center;
        
        }
        
        img[alt="techone"] {
        height: 49px;
        width: 59px;
        
        transform: rotate(-45deg);
        }
        
        .log-in {
        float: left;
        width: 49%;
        }
        
        .input {
        width: 200px;
        background-color: transparent;
        border: 0;
        outline: 0;
        padding-left: 4px;
        font-weight: 500;
        font-size: 1.1em;
        }
        
        .input-style {
        text-align: center;
        border-radius: 5px;
        border: solid 1.9px black;
        margin: 0 8%;
        }
        
        .input-style:hover {
        border: 1.9px solid rgb(0, 55, 144);
        }
        .signin {
        border: 1.3px solid red;
        padding: 4px 30px;
        background-color:rgba(169, 169, 169, 0.37);
        border-radius: 5px;
        font-size: 1em;
        margin-left: 8%;
        letter-spacing: 1.5px;
        }
        
        .signin:hover {
        background-color: rgba(169, 169, 169, 0.233);
        color: rgb(91, 4, 4);
        cursor: pointer;
        }
        .sign_error{
        color:rgba(255, 0, 0, 0.856);
        font-size:.75em;
        margin: 10px 0 -10px 8%;
        letter-spacing: 1px;
        }
        .trouble {
        width: 100%;
        font-size: .75em;
        margin-left: 8%;
        margin-top: 8px;
        letter-spacing: 1px;
        }
        
        .social {
        height: auto;
        width: 50%;
        font-size: 1.1em;
        float: right;
        border-left: 1.4px solid black;
        text-align: center;
        }
        
        .fig {
        margin: 0px 30px 0px 30px;
        border: 1.5px solid darkblue;
        border-radius: 20px;
        text-align: center;
        }
        button{
        background:transparent;
        outline:0;
        border:0;
        width: 100%;
        font-family: candara;
        font-weight: 600;
        font-size:1em;
        cursor: pointer;
        color:white;
        }
        .fa-facebook , .fa-instagram, .fa-google{
        color: white;
        margin-right: 5px;
        }
        .Facebook{
        background-color: #4267B2;
        }
        .Instagram{
        background-color: #ff66b3;
        }
        .Google{
        background-color: #ff4d4d;
        }
        .fa-user {
        color: rgb(0, 55, 144);
        }
        .fa-key {
        color: rgb(0, 55, 144);
        }
        
        .figlogo {
        height: 23px;
        width: 23px;
        color: white;
        margin-top: 0px;
        margin: 0 2px 0 5px;
        float: left;
        }
        .fa-eye{
        position: absolute;
        z-index: 2;
        margin-left:-15px ;
        background-color:transparent;
        font-size:1.2em;
        cursor: pointer;
        border:0;
        }
        .fa-eye:hover{
        color:palevioletred;
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
        form {
        height: 350px;
        width: 275px;
        border-top-left-radius: 15px;
        border-bottom-right-radius: 15px;
        box-shadow: 8Px 8px 14px rgba(53, 46, 46, 0.746);
        }
        
        .social-login {
        font-size: 15px;
        }
        
        .log-in {
        margin: -20px 0 10px 0;
        width: 100%;
        border-bottom: 1px solid black;
        padding-bottom:7px ;
        }
        
        .input {
        font-size: 13px;
        width: 190px;
        }
        
        .input-style {
        margin-bottom: -7px;
        }
        
        .logo-div img {
        height: 35px;
        width: 45px;
        margin: 15px 5px;
        }
        
        .logo-div {
        margin: -35px 70% 0 5%;
        padding: 4px;
        height: 17%;
        }
        
        .signin {
        font-size: 12px;
        padding: 3px 10px;
        }
        .sign_error{
        font-size: .65em;
        }
        
        .trouble {
        font-size: 9.5px;
        }
        
        .social {
        border: none;
        width: 100%;
        margin-top: -20px;
        }
        
        .fig {
        display: inline-table;
        margin:4px 0;
        font-size: 12.5px;
        width: 180px;
        }
        .figlogo {
        height: 16px;
        width: 16px;
        margin: 0 5px;
        }
        .fa-eye{
        font-size:.9em;
        margin-top:5px;
        }
        .footer div{
        line-height: 45px;
        font-size:.5rem;
        }
        }
        
        @media only screen and (min-width:318px) and (max-width:350px) {
        
        form {
        height: 350px;
        width: 280px;
        border-top-left-radius: 15px;
        border-bottom-right-radius: 15px;
        }
        
        .logo-div {
        margin: -40px 69.5% 0 5%;
        padding: 4px;
        height: 17%;
        }
        
        .logo-div img {
        height: 35px;
        width: 45px;
        margin: 15px 5px;
        }
        
        .social-login {
        font-size: 15px;
        }
        
        .log-in {
        width: 100%;
        border-bottom: 1px solid black;
        padding-bottom:10px ;
        margin: -25px 0 10px 0;
        }
        
        .input {
        font-size: 13px;
        }
        
        .input-style {
        margin-bottom: -7px;
        }
        .fa-eye{
        margin-left:-25px ;
        }
        
        .signin {
        font-size: 14px;
        padding: 2px 15px;
        }
        .sign_error,.trouble{
        font-size: .65em;
        }
        .social {
        margin-top: -20px;
        border: none;
        width: 100%;
        }
        
        .fig {
        display: inline-table;
        font-size: 13px;
        margin: 4px 0;
        width: 180px;
        }
        
        .figlogo {
        height: 17px;
        width: 17px;
        margin: 1px 3px 1px 2px;
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 40px;
        font-size:.55rem;
        }
        }
        
        @media only screen and (min-width: 351px) and (max-width: 370px) {
        
        .logo-div {
        margin: -35px 71.5% 0 5%;
        padding: 4px;
        height: 17%;
        }
        
        .logo-div img {
        height: 35px;
        width: 45px;
        margin: 17px 5px;
        }
        
        form {
        height: 380px;
        width: 310px;
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        }
        
        .social-login {
        font-size: 15px;
        }
        
        .log-in {
        width: 100%;
        height: 44.5%;
        border-bottom: 1px solid black;
        padding-bottom:13px ;
        }
        .input {
        font-size: 12px;
        }
        
        .input-style {
        margin-top: -10px;
        padding: 0;
        }
        
        .signin {
        font-size: 12px;
        padding: 3px 10px;
        margin-left: 8%;
        }
        
        .sign_error,.trouble{
        font-size: .66em;
        }
        .social {
        margin-top: -20px;
        border: none;
        width: 100%;
        }
        
        .social {
        margin-top:-5px ;
        border: none;
        width: 100%;
        }
        
        .fig {
        margin: 0 20% -15px 20%;
        font-size: 12.5px;
        text-align: center;
        }
        
        .figlogo {
        height: 17px;
        width: 17px;
        
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 40px;
        font-size:.65rem;
        }
        }
        
        @media only screen and (min-width: 371px) and (max-width:400px) {
        
        form {
        height: 370px;
        width: 310px;
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        }
        
        .logo-div {
        margin: -35px 71% 0 5%;
        padding: 4px;
        height: 17%;
        }
        
        .logo-div img {
        height: 38px;
        width: 48px;
        margin: 15px 5px;
        }
        
        .social-login {
        font-size: 15px;
        margin-bottom: -20px;
        }
        
        .log-in {
        width: 100%;
        border-bottom: 1px solid black;
        padding-bottom: 10px;
        }
        
        .input {
        font-size: 13px;
        }
        
        .input-style {
        margin-bottom: -7px;
        }
        
        .signin {
        font-size: 13px;
        padding: 3px 7px;
        }
        .sign_error,.trouble{
        font-size: .65em;
        }
        .social {
        margin-top: -5px;
        border: none;
        width: 100%;
        }
        .fig {
        margin: 0 21% -15px 21%;
        font-size: 14px;
        text-align: center;
        }
        .figlogo {
        height: 18px;
        width: 18px;
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 55px;
        font-size:.70rem;
        }
        }
        
        @media only screen and (min-width: 401px) and (max-width:433px) {
        .logo-div {
        margin: -35px 70.5% 0 6%;
        padding: 4px;
        height: 17%;
        }
        
        .logo-div img {
        height: 38px;
        width: 48px;
        margin: 15px 5px;
        }
        
        form {
        height: 375px;
        width: 310px;
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        }
        
        .social-login {
        font-size: 15px;
        }
        
        .log-in {
        width: 100%;
        border-bottom: 1px solid black;
        padding-bottom: 10px;
        }
        
        .input {
        font-size: 13px;
        }
        
        .input-style {
        margin: -20px 10% 6px 10%;
        
        }
        .signin {
        font-size: 13px;
        padding: 2px 17px;
        margin-left:10% ;
        }
        .sign_error,.trouble{
        margin-left: 10%;
        font-size: 10.49px;
        letter-spacing: 1.2px;
        }
        .social {
        margin-top: -5px;
        border: none;
        padding-top: 10px;
        width: 100%;
        }
        .fig {
        margin: -12px 20% 0 20%;
        font-size: 15px;
        text-align: center;
        }
        .figlogo {
        height: 17px;
        width: 17px;
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 50px;
        font-size:.75rem;
        }
        }
        
        @media only screen and (min-width: 434px) and (max-width:500px) {
        .logo-div {
        margin: -35px 70% 0 6%;
        padding: 4px;
        height: 17%;
        }
        
        .logo-div img {
        height: 38px;
        width: 48px;
        margin: 16px 5px;
        }
        
        form {
        height: 380px;
        width: 310px;
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        }
        
        .social-login {
        font-size: 15px;
        }
        
        .log-in {
        width: 90%;
        border-bottom: 1px solid black;
        padding-bottom :10px; ;
        margin: 0 0 5% 20px;
        }
        
        .input {
        font-size: 14px;
        }
        
        .input-style {
        margin: -15px 8% 2px 8%;
        padding: 0;
        }
        .fa-eye{
        margin-left:-20px ;
        }
        .signin {
        font-size: 14px;
        padding: 2px 20px;
        }
        
        .social {
        padding-top: -15px;
        border: none;
        width: 100%;
        }
        .sign_error,.trouble{
        margin-left: 8%;
        font-size: 10.48px;
        letter-spacing: 1.3px;
        }
        .fig {
        margin: -22px 22% 6px 22%;
        font-size: 14.5px;
        text-align: center;
        }
        .figlogo {
        height: 17px;
        width: 17px;
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 50px;
        font-size:.80rem;
        }
        }
        @media screen and (min-width:501px) and (max-width: 599px) {
        
        .logo-div {
        margin: -35px 70% 0 6%;
        padding: 4px;
        height: 17%;
        }
        
        .logo-div img {
        height: 38px;
        width: 48px;
        margin: 16px 5px;
        }
        
        form {
        height: 380px;
        width: 310px;
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        }
        
        .social-login {
        font-size: 16px;
        }
        
        .log-in {
        width: 90%;
        margin: 0 0 5% 20px;
        }
        
        .input {
        font-size: 14px;
        }
        .input-style {
        margin: -15px 8% 2px 8%;
        padding: 0;
        }
        .fa-eye{
        margin-left:-20px ;
        }
        .signin {
        font-size: 14.4px;
        padding: 2px 20px;
        }
        .sign_error,.trouble{
        margin-left: 8%;
        font-size: 10.48px;
        letter-spacing: 1.1px;
        }
        .social {
        padding-top: 10px;
        border: none;
        border-top: 1px solid black;
        width: 100%;
        }
        .fig {
        margin: -20px 21.2% 6px 21.2%;
        font-size: 14.3px;
        text-align: center;
        }
        .figlogo {
        height: 18px;
        width: 18px;
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 50px;
        font-size:.85rem;
        }
        }
        @media screen and (min-width:600px) and (max-width: 699px) {
        .logo-div {
        margin: -45px 76% 0 6%;
        padding: 5px;
        height: 25%;
        }
        .logo-div img {
        height: 45px;
        width: 55px;
        margin: 18px 5px;
        }
        form {
        height: 320px;
        width: 520px;
        border-top-left-radius: 30px;
        border-bottom-right-radius: 30px;
        }
        .social-login {
        font-size: 17px;
        margin-bottom: -20px;
        }
        .log-in {
        float: left;
        margin-top: 4%;
        height: 44.5%;
        }
        .input {
        font-size: 15px;
        width: 170px;
        }
        .input-style {
        margin: 0 8% -5px 8%;
        padding: 0;
        }
        .signin {
        font-size: 15px;
        padding: 2px 15px;
        margin-left: 8%;
        }
        .sign_error,.trouble{
        margin-left: 8%;
        font-size: .7em;
        letter-spacing: 1.1px;
        }
        .social {
        margin-top: 5%;
        width: 50%;
        height: 55%;
        border-left: 1px solid black;
        float: right
        }
        .fig {
        margin: 3% 10% -7% 10%;
        font-size: 15.5px;
        text-align: center;
        }
        .figlogo {
        height: 20px;
        width: 20px;
        }
        .fa-eye{
        font-size:1em;
        margin-top:2px;
        }
        .footer div{
        line-height: 50px;
        font-size:.85rem;
        }
        }
        
        @media screen and (min-width:700px) {
        .logo-div {
        margin: -45px 78% 0 6%;
        padding: 6px;
        height: 23%;
        }
        .social{
        padding: 20px 0;
        }
        .logo-div img {
        height: 50px;
        width: 60px;
        padding-right: 5px;
        margin: 16px 5px;
        }
        .fa-eye{
        font-size:1.1em;
        margin-top:3px;
        }
        }
        </style>
        
        <body>
            <div class="container">
                <div class="form_div">
                    <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='POST'>
                        <div class="logo-div"><img src="favicon1.png" draggable="false" role="img" alt="techone" /></div>
                        <div class="social-login">SIGN-IN</div><br>
                        <div class="log-in"><br>
                            <div class="input-style">
                                <i class="fa fa-user" style="margin:0 3px 0 2px;"></i>
                                <input id="username" type="text" name="user" class="input" placeholder="Username or Email" autocomplete="off" required />
                            </div><br>
                            <div class="input-style">
                                <i class="fa fa-key" style="margin-left:0px;"></i>
                                <input id="password" name="pass" class="input" placeholder="Password" type="password" autocomplete="off" required />
                                <i onclick="pwdShow();" class="fa fa-eye" aria-hidden="true"></i>
                            </div>
                            <?php
                            echo "<p class='sign_error'>$error</p>";
                            ?><br>
                            <input type="Submit" value="SIGN-IN" class="signin" name="Submit"/>
                            <br />
                            <div class="trouble">Trouble logging in?- <a href="Trouble.php">click here</a></div>
                            <div class="trouble">Sign-up?- <a href="Register.php">Register here</a></div>
                        </div>
                        <div class="social"><br>
                            <div class="fig Facebook"><button><i class="fab fa-facebook figlogo"></i>Sign in with Facebook</button></div><br>
                            <div class="fig Instagram"><button><i class="fab fa-instagram figlogo"></i>Sign in with Instagram</button></div><br>
                            <div class="fig Google"><button><i class="fab fa-google figlogo"></i>Sign in with Google</button></div><br>
                        </div>
                    </form>
                </div>
            </div>
            <footer class="footer">
                <div style="line-height: 65px;">
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
        var x = document.getElementById("password");
        if (x.type === "password") {
        x.type = "text";
        } else {
        x.type = "password";
        }
        }
        </script>
    </html>
    <?php mysqli_close($conn); ?>