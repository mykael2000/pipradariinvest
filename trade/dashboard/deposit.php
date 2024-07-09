<?php
  include("includes/header.php");
   if(isset($_POST['deposit'])){
        $amount = $_POST['amount'];
        $coin = $_POST['coin'];

        if($coin == "USDT"){
            header("location:usdt.php");
        }
        if($coin == "BTC"){
            header("location:btc.php");
        }
        if($coin == "ETH"){
            header("location:eth.php");
        }
        if($coin == "LTC"){
            header("location:ltc.php");
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
    $type = "deposit";
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
                header("location: deposit.php?st=pend");
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
            <div>Proof of Deposit Uploaded successfully</div>
        </div>';
}
?>

<div class="container-fluid content-inner pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <h3 class="p-3">Deposit into your wallet</h3>
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

                            <div id="emailHelp" class="form-text">Deposit reflects after 2 network confirmations.</div>
                        </div>
                        <button name="deposit" type="submit" class="btn btn-primary">Deposit</button>
                    </form>
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

<?php
   
    include("includes/footer.php");
?>