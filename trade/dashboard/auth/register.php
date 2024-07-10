<?php
 include("../includes/connection.php");
 ob_start(); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 


    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $currency = "USD";
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["cpassword"];
    $username = $_POST['username'];
    $country = $_POST['country'];
    $referral_code = $_POST['referral_code'];

    // Validate form inputs (You can add more validation)
    if ($password !== $confirmpassword) {
        echo "Passwords do not match. Please try again.";
        header("refresh:1;url=../../register.html");
        exit; // Stop further execution
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

          // Check if the email address is already in use
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
           echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
               The email has already been taken
            </div>
        </div>';
        header("refresh:1;url=../../register.html");
        } else {
            // Insert user data into the database
            $insertQuery = "INSERT INTO users (firstname, lastname, username, email, currency, country, phone, password, referrer_code)
                            VALUES ('$firstname','$lastname','$username','$email', '$currency', '$country', '$phone', '$hashedPassword', '$referral_code')";
           $insert = mysqli_query($conn, $insertQuery);
            if($insert) { 
                echo 'Account successfully created! <br>redirecting now......';
        header("refresh:1;url=../../login.html");
         
            try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.pipradariinvest.org';                     //Set the SMTP server to send through
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
    $mail->Subject = 'Successful Registration';
    $mail->Body    = '<html><head></head></head>
<body style="background-color: #1e2024; padding: 45px;">
    <div>
        <img style="position:relative; left:35%;" src="https://pipradariinvest.org/trade/dashboard/logo.png">
        <h3 style="color: black;">Mail From support@pipradariinvest.org - Successful Registration</h3>
    </div>
    <div style="color: #ffff;"><hr/>
        <h3>Dear '.$firstname.'</h3>
        <p>You are welcome to Pipradariinvest, an automated  online trading  platform made so even investors with zero trading experience  are successfully making profit </p>
        
        <h5>Note : the details in this email should not be disclosed to anyone</h5>
            
    </div><hr/>
        <div style="background-color: white; color: black;">
            <h3 style="color: black;">support@Pipradariinvest<sup>TM</sup> </h3>
        </div>
        
</body></html>

';
   
    $mail->send();
    // echo 'Email has been sent to '.$email;
    header("refresh:1;url=../../login.html");
         
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("refresh:1;url=../../login.html");
         
}
header("refresh:1;url=../../login.html");
         
            } else {
                echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
                echo "error";
            }
        }                      

        $conn->close();
    }

?>

