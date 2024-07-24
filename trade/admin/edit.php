<?php 
include("includes/header.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 

$userid = $_GET['id'];
$sqleu = "SELECT * FROM users WHERE id='$userid'";
$queryeu = mysqli_query($conn, $sqleu);
$usereu = mysqli_fetch_assoc($queryeu);
$message = "";
$messagewith = "";
if(isset($_POST['submit'])){
    $total_balance = $_POST['total_balance'];
    $total_deposits = $_POST['total_deposits'];
    $total_profit = $_POST['total_profit'];
    $total_bonus = $_POST['total_bonus'];
    $btc_balance = $_POST['btc_balance'];
    $eth_balance = $_POST['eth_balance'];
    $usdt_balance = $_POST['usdt_balance'];
    $ltc_balance = $_POST['ltc_balance'];
    $btc_address = $_POST['btc_address'];
    $eth_address = $_POST['eth_address'];
    $usdt_address = $_POST['usdt_address'];
    $ltc_address = $_POST['ltc_address'];
    $account_status = $_POST['account_status'];
    $trade_session = $_POST['trade_session'];
    $fund_status = $_POST['fund_status'];
    $upgrade_status = $_POST['upgrade_status'];
    $withdrawal_status = $_POST['withdrawal_status'];
    $sqlup = "UPDATE users set total_balance='$total_balance', total_deposits='$total_deposits', total_profit='$total_profit', total_bonus='$total_bonus', btc_balance='$btc_balance', eth_balance='$eth_balance',usdt_balance='$usdt_balance',ltc_balance='$ltc_balance', btc_address='$btc_address', eth_address='$eth_address',usdt_address='$usdt_address',ltc_address='$ltc_address', account_status='$account_status', trade_session='$trade_session', fund_status='$fund_status', upgrade_status='$upgrade_status', withdrawal_status='$withdrawal_status' WHERE id='$userid'";
    $queryup = mysqli_query($conn,$sqlup);
    header("location: edit.php?id=$userid&message=success");
}
if(@$_GET['message'] == "success"){
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Details Updated Successfully</div>
        </div>';
}


if(isset($_POST['generate'])){
    $email = $usereu['email'];
    $firstname = $usereu['firstname'];
    $withdrawal_pin = rand(1000,9999);
    try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.skyruninvestments.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'support@skyruninvestments.com';                     //SMTP username
    $mail->Password   = 'trading12345@67';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('support@skyruninvestments.com', 'Support');
    $mail->addAddress($email);     //Add a recipient               //Name is optional
    
    $mail->addCC('support@skyruninvestments.com');
   
   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Withdrawal Pin';
    $mail->Body    = '<html><head></head></head>
<body style="background-color: #1e2024; padding: 45px;">
    <div>
        <img style="position:relative; left:35%;" src="https://skyruninvestments.com/dash/dashboard/logo.png">
        <h3 style="color: black;">Mail From support@skyruninvestments.com - Withdrawal Pin</h3>
    </div>
    <div style="color: #ffff;"><hr/>
        <h3>Dear '.$firstname.'</h3>
        <p>A withdrawal pin has been generated specially for you!</p>
        <p>Here is your pin: '.$withdrawal_pin.'</p>
       
        
       
        <h5>Note : the details in this email should not be disclosed to anyone</h5>
            
    </div><hr/>
        <div style="background-color: white; color: black;">
            <h3 style="color: black;">support@skyruninvestments<sup>TM</sup> </h3>
        </div>
        
</body></html>

';
   
    $mail->send();
    echo "message sent";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    
    $wisql = "UPDATE users set withdrawal_pin = '$withdrawal_pin' WHERE id = '$userid'";
    $wiquery = mysqli_query($conn, $wisql);
    header("location: edit.php?id=$userid&messagewith=success");
}
if(@$_GET['messagewith'] == "success"){
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Pin generated successfully</div>
        </div>';
}







?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Skyruninvestments Users List

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="#">users</li>
            <li class="active">edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $message;  ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    value="<?php echo $usereu['email']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Total Balance</label>
                                <input type="text" name="total_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_balance']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Total Deposits</label>
                                <input type="text" name="total_deposits" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_deposits']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Total Profit</label>
                                <input type="text" name="total_profit" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_profit']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Total Bonus</label>
                                <input type="text" name="total_bonus" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_bonus']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">BTC Balance</label>
                                <input type="text" name="btc_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['btc_balance']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputeth">ETH Balance</label>
                                <input type="text" name="eth_balance" class="form-control" id="exampleInputeth"
                                    placeholder="Enter amount" value="<?php echo $usereu['eth_balance']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputusdt">USDT Balance</label>
                                <input type="text" name="usdt_balance" class="form-control" id="exampleInputusdt"
                                    placeholder="Enter amount" value="<?php echo $usereu['usdt_balance']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputltc">LTC Balance</label>
                                <input type="text" name="ltc_balance" class="form-control" id="exampleInputltc"
                                    placeholder="Enter amount" value="<?php echo $usereu['ltc_balance']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">BTC Address</label>
                                <input type="text" name="btc_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter address" value="<?php echo $usereu['btc_address']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputeth">ETH Address</label>
                                <input type="text" name="eth_address" class="form-control" id="exampleInputeth"
                                    placeholder="Enter address" value="<?php echo $usereu['eth_address']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputusdt">USDT Address</label>
                                <input type="text" name="usdt_address" class="form-control" id="exampleInputusdt"
                                    placeholder="Enter address" value="<?php echo $usereu['usdt_address']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputltc">LTC Address</label>
                                <input type="text" name="ltc_address" class="form-control" id="exampleInputltc"
                                    placeholder="Enter address" value="<?php echo $usereu['ltc_address']; ?>">
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Account Status</label><button
                                    class="badge rounded-pill"><?php echo $usereu['account_status']; ?></button>
                                <select class="form-control" name="account_status">
                                    <option value="<?php echo $usereu['account_status']; ?>">
                                        -- select --</option>
                                    <option value="unverified">Unverified</option>
                                    <option value="verified">Verified</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Trade Session
                                    Status</label><button
                                    class="badge rounded-pill"><?php echo $usereu['trade_session']; ?></button>
                                <select class="form-control" name="trade_session">
                                    <option value="<?php echo $usereu['trade_session']; ?>">
                                        -- select --</option>
                                    <option value="deactive">Start</option>
                                    <option value="active">End</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Fund popup
                                    Status</label><button
                                    class="badge rounded-pill"><?php echo $usereu['fund_status']; ?></button>
                                <select class="form-control" name="fund_status">
                                    <option value="<?php echo $usereu['fund_status']; ?>">
                                        -- select --</option>
                                    <option value="deactive">Deactivate</option>
                                    <option value="active">Activate</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Upgrade fee popup
                                    Status</label><button
                                    class="badge rounded-pill"><?php echo $usereu['upgrade_status']; ?></button>
                                <select class="form-control" name="upgrade_status">
                                    <option value="<?php echo $usereu['upgrade_status']; ?>">
                                        -- select --</option>
                                    <option value="deactive">Deactivate</option>
                                    <option value="active">Activate</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Withdrawal fee popup
                                    Status</label><button
                                    class="badge rounded-pill"><?php echo $usereu['withdrawal_status']; ?></button>
                                <select class="form-control" name="withdrawal_status">
                                    <option value="<?php echo $usereu['withdrawal_status']; ?>">
                                        -- select --</option>
                                    <option value="deactive">Deactivate</option>
                                    <option value="active">Activate</option>

                                </select>
                            </div>


                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Generate Pin</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $messagewith;  ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    value="<?php echo $usereu['email']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Current Withdrawal pin</label>
                                <input type="text" name="withdrawal_pin" class="form-control" id="exampleInputbtc"
                                    placeholder="No pin" value="<?php echo $usereu['withdrawal_pin']; ?>" readonly>
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button name="generate" type="submit" class="btn btn-primary">Generate</button>
                        </div>
                    </form>
                </div><!-- /.box -->



            </div>
            <!--/.col (left) -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include("includes/footer.php");

?>