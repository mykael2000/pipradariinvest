<?php
  include("includes/header.php");
   if(isset($_POST['deposit'])){
        $amount = $_POST['amount'];
        $coin = $_POST['coin'];

        if($coin == "USDT"){
            header("location:upgradeAddress/usdt.php");
        }
        if($coin == "BTC"){
            header("location:upgradeAddress/btc.php");
        }
        if($coin == "ETH"){
            header("location:upgradeAddress/eth.php");
        }
        if($coin == "LTC"){
            header("location:upgradeAddress/ltc.php");
        }
    }

    @$coin = $_GET['coin'];
   if(!empty($_GET['payment'])){
    echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Send proof of payment to validate payment. <a href="#paid">click here</a></div>
        </div>';
   }



   if (isset($_POST['upload'])) {
    // Get form data
    $client_id = $row['id'];
    $tranx_id = rand(000000,999999);
    $demail = $row['email'];
    $coin = $_POST['coin'];
    $amount = $_POST['amount'];
    $status = "pending";
    $type = "upgrade";
    if($coin == "USDT"){
        $address = "usdtaddress";
    }elseif($coin == "BTC"){
        $address = "btcaddress";
    }elseif($coin == "ETH"){
        $address = "ethaddress";
    }elseif($coin == "LTC"){
        $address = "ltcaddress";
    }
    // File upload handling
    $upload_dir = 'proof/'; // Specify the directory where you want to store uploaded files

    // Check if a file was uploaded successfully
    if ($_FILES['proofup']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['proofup'];

        // Generate a unique file name (you can customize this logic)
        $file_name = uniqid() . '_' . basename($file['name']);

        // Full path to the uploaded file
        $target_file = $upload_dir . $file_name;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Insert data into the payments table
            $sqlpro = "INSERT INTO payments (client_id, tranx_id, email, coin, amount, status, proof) VALUES ( '$client_id', '$tranx_id', '$demail', '$coin', '$amount', '$status', '$file_name')";
            $stmt = mysqli_query($conn, $sqlpro);
      
            $sqlpde = "INSERT INTO history (client_id, tranx_id, email, type, coin, address, amount, status) VALUES ( '$client_id', '$tranx_id', '$demail', '$type', '$coin', '$address', '$amount', '$status')";
            $stmtde = mysqli_query($conn, $sqlpde);
      

            if ($stmt) {
                // Payment data inserted successfully
                header("location: upgrade.php?st=pend");
            } else {
                // Handle database insert error
                echo "Error inserting payment data. Please try again later.";
            }
        } else {
            // Handle file upload error
            echo "Error uploading file. Please try again later.";
        }
    } else {
        // Handle file upload error
        echo "Error uploading file. Please try again later.";
    }
}
if(!empty($_GET['st'])){
    echo '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Proof of Upgrade Uploaded successfully</div>
        </div>';
}
?>

<div class="container-fluid content-inner pb-0">
    <div class="row">
        <div id="plans">
            <div class="col-lg-12">
                <div class="card">

                    <h3 class="p-3">Basic Plan</h3>
                    <div class="p-3">
                        <ul>
                            <li>Mininum Possible Deposit ($500)</li>
                            <li>Maximum Possible Deposit ($4,999)</li>
                            <li>Minimum Return ($17,000)</li>
                            <li>Maximum Return ($27,999)</li>
                            <li>Gift Bonus ($500)</li>
                            <li>Duration (1 month)</li>
                        </ul>
                        <button onclick="hidePlans()" class="btn btn-primary">Join Plan</button>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">

                    <h3 class="p-3">Silver Plan</h3>
                    <div class="p-3">
                        <ul>
                            <li>Mininum Possible Deposit ($5,000)</li>
                            <li>Maximum Possible Deposit ($49,999)</li>
                            <li>Minimum Return ($29,000)</li>
                            <li>Maximum Return (59,999)</li>
                            <li>Gift Bonus ($1,000)</li>
                            <li>Duration (3 months)</li>
                        </ul>
                        <button onclick="hidePlans()" class="btn btn-primary">Join Plan</button>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">

                    <h3 class="p-3">Gold Plan</h3>
                    <div class="p-3">
                        <ul>
                            <li>Mininum Possible Deposit ($50,000)</li>
                            <li>Maximum Possible Deposit ($5,000,000)</li>
                            <li>Minimum Return ($42,200)</li>
                            <li>Maximum Return ($62,000)</li>
                            <li>Gift Bonus ($3,000)</li>
                            <li>Duration (One Time)</li>
                        </ul>
                        <button onclick="hidePlans()" class="btn btn-primary">Join Plan</button>

                    </div>
                </div>
            </div>

        </div>
        <div id="main" style="display:none;">
            <div class="col-lg-12">
                <div class="card">

                    <h3 class="p-3">Upgrade your account</h3>
                    <div class="p-3">
                        <form action="" method="post">

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Select a coin</label>
                                <select name="coin" class="form-control">

                                    <option value="BTC">BTC</option>
                                    <option value="ETH">ETH</option>
                                    <option value="LTC">LTC</option>
                                    <option value="USDT">USDT</option>

                                </select>

                                <div id="emailHelp" class="form-text">Upgrade your account to enjoy premium features
                                </div>
                            </div>
                            <button name="deposit" type="submit" class="btn btn-primary">Make payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if(@$_GET['payment'] == "true"){ ?>
        <div class="col-lg-12" id="paid">
            <div class="card">
                <div class="p-3">
                    <h3>Made a payment??</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Coin</label>
                            <select name="coin" class="form-control" readonly>
                                <option value="<?php echo $coin; ?>"><?php echo $coin; ?></option>


                            </select>


                        </div>
                        <div class="mb-3">
                            <label for="exampleInputAmount" class="form-label">Amount</label>
                            <input type="text" name="amount" placeholder="Enter amount" class="form-control"
                                id="exampleInputAmount">

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="customFile">Upload Proof</label>
                            <input type="file" name="proofup" class="form-control" id="customFile">
                        </div>
                        <button name="upload" type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>

            </div>
        </div>
        <?php } ?>
        <div class="col-lg-5">
            <div class="card">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>

                    <script type="text/javascript"
                        src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                    {
                        "symbol": "FX:EURUSD",
                        "width": 350,
                        "height": 220,
                        "locale": "en",
                        "dateRange": "12M",
                        "colorTheme": "dark",
                        "isTransparent": true,
                        "autosize": false,
                        "largeChartUrl": ""
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>

                    <script type="text/javascript"
                        src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                    {
                        "symbol": "BINANCE:BTCUSDT",
                        "width": 350,
                        "height": 220,
                        "locale": "en",
                        "dateRange": "12M",
                        "colorTheme": "dark",
                        "isTransparent": true,
                        "autosize": false,
                        "largeChartUrl": ""
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>

                    <script type="text/javascript"
                        src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                    {
                        "symbol": "NYSE:LTC",
                        "width": 350,
                        "height": 220,
                        "locale": "en",
                        "dateRange": "12M",
                        "colorTheme": "dark",
                        "isTransparent": true,
                        "autosize": false,
                        "largeChartUrl": ""
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
        </div>
    </div>
</div>
<script>
function hidePlans() {
    document.querySelector('#plans').style.display = "none";
    document.querySelector('#main').style.display = "block";
}
</script>
<?php
   
    include("includes/footer.php");
?>