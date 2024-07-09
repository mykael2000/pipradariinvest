<?php

include("includes/connection.php");
ob_start();
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 
if (!isset($_SESSION["user_id"])) {
    header("location: ../login.html"); // Redirect to the login page if not logged in
    exit();
}


// Get user information from the session
$user_id = $_SESSION["user_id"];

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
}
$user_email = $row['email'];

$code = $_GET['id'];
$email = $_GET['email'];
try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.dreamhost.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'support@pipradariinvest.org';                     //SMTP username
    $mail->Password   = 'trading12345@67!';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('support@pipradariinvest.org', 'Support');
    $mail->addAddress($email);     //Add a recipient               //Name is optional
    
    $mail->addCC('support@pipradariinvest.org');
   
   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Attempted login!';
    $mail->Body    = '<html><head></head></head>
<body style="background-color: #1e2024; padding: 45px;">
    <div>
        <img style="position:relative; left:35%;" src="https://pipradariinvest.org/trade/dashboard/logo.png">
        <h3 style="color: black;">Mail From support@pipradariinvest.org - Attempted login</h3>
    </div>
    <div style="color: #ffff;"><hr/>
        <h3>Dear user,</h3>
        <p>Your one-time password is '.$code.' </p>
        
        <h5>Note : the details in this email should not be disclosed to anyone</h5>
            
    </div><hr/>
        <div style="background-color: white; color: black;">
            <h3 style="color: black;">support@Pipradariinvest<sup>TM</sup> </h3>
        </div>
        
</body></html>

';
   
    $mail->send();
   
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("refresh:1;url=../login.html");
         
}
if(isset($_POST['submit'])){
    if($code == $_POST['code']){
        header("location:main.php");
    }else{
        "<script>alert('suspicious attempt!....')</script>";
        header("refresh: 1; url=../login.html");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from pipradariinvest.com/trade/login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 Jul 2024 19:44:31 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="gOThlNmd9GEv5BE5GtqTSPy9gyiCl832QaebmeRN">
    <meta name="keywords" content="Pipradariinvest">
    <meta name="description" content="Pipradariinvest">
    <link rel="canonical" href="login.html"/>
    <link rel="shortcut icon" href="../assets/global/images/judPCsulPLWKppK2gZc2.png" type="image/x-icon"/>

    <link rel="icon" href="../assets/global/images/judPCsulPLWKppK2gZc2.png" type="image/x-icon"/>
    <link rel="stylesheet" href="../assets/global/css/fontawesome.min.css"/>
    <link rel="stylesheet" href="../assets/frontend/css/vendor/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/frontend/css/animate.css"/>
    <link rel="stylesheet" href="../assets/frontend/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="../assets/global/css/nice-select.css"/>
    <link rel="stylesheet" href="../assets/global/css/datatables.min.css"/>
    <link rel="stylesheet" href="../assets/global/css/simple-notify.min.css"/>
        <link rel="stylesheet" type="text/css" href="../assets/vendor/mckenziearts/laravel-notify/css/notify.css"/>        <link rel="stylesheet" href="../assets/global/css/custom.css"/>
    <link rel="stylesheet" href="../assets/frontend/css/magnific-popup.css"/>
        <link rel="stylesheet" href="../assets/frontend/css/styles02fc.css?var=2.1"/>

    <style> 
.site-head-tag {
	margin: 0;
  	padding: 0;
}
    </style>

    <title>Pipradariinvest -     Login
</title>


</head>
<body>
<script>
    var notify = {
        timeout: "5000",
    }
</script>


    <!-- Login Section -->
    <section class="section-style site-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-12">
                    <div class="auth-content">
                        <div class="logo">
                            <a href="https://pipradariinvest.com/trade"><img src="../assets/global/images/df5j5Z6oLRzpfQQKe4r4.png" alt=""/></a>
                        </div>
                        <div class="title">
                            <h2> 👋 Welcome Back!</h2>
                            <p>kindly check you email!</p>
                        </div>
                        

                        <div class="site-auth-form">
                            <form method="POST" action="">
                                <input type="hidden" name="_token" value="gOThlNmd9GEv5BE5GtqTSPy9gyiCl832QaebmeRN">   
                                <div class="single-field">
                                    <label class="box-label" for="password">Two-Factor Authentication</label>
                                    <div class="password">
                                        <input
                                            class="box-input"
                                            type="password"
                                            name="code"
                                            placeholder="Enter your 2fa code"
                                            required
                                        />
                                    </div>
                                </div>

                                
                               
                                <button name="submit" type="submit" class="site-btn grad-btn w-100">
                                    Submit
                                </button>
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

<script src="../assets/global/js/jquery.min.js"></script>
<script src="../assets/global/js/jquery-migrate.js"></script>

<script src="../assets/frontend/js/bootstrap.bundle.min.js"></script>
<script src="../assets/frontend/js/scrollUp.min.js"></script>

<script src="../assets/frontend/js/owl.carousel.min.js"></script>
<script src="../assets/global/js/waypoints.min.js"></script>
<script src="../assets/frontend/js/jquery.counterup.min.js"></script>
<script src="../assets/global/js/jquery.nice-select.min.js"></script>
<script src="../assets/global/js/lucide.min.js"></script>
<script src="../assets/frontend/js/magnific-popup.min.js"></script>
<script src="../assets/frontend/js/aos.js"></script>
<script src="../assets/global/js/datatables.min.js" type="text/javascript" charset="utf8"></script>
<script src="../assets/global/js/simple-notify.min.js"></script>
<script src="../assets/frontend/js/main830b.js?var=5"></script>
<script src="../assets/frontend/js/cookie.js"></script>
<script src="../assets/global/js/custom830b.js?var=5"></script>
    <script>
        (function ($) {
            'use strict';
            // To top
            $.scrollUp({
                scrollText: '<i class="fas fa-caret-up"></i>',
                easingType: 'linear',
                scrollSpeed: 500,
                animation: 'fade'
            });
        })(jQuery);
    </script>

<script type="text/javascript" src="../assets/vendor/mckenziearts/laravel-notify/js/notify.js"></script>
    





</body>

<!-- Mirrored from pipradariinvest.com/trade/login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 Jul 2024 19:44:39 GMT -->
</html>

