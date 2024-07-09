<?php
  include("includes/header.php");

  
if (isset($_POST['proceed'])) {
    // Retrieve form data
    $client_id = $row['id'];
    $tranx_id = rand(000000,999999);
    $email = $row['email'];
    $amount = $_GET['amount'];
    $accountNumber = $_GET['accountNumber'];
    $bankName = $_GET['bankName'];
    $accountName = $_GET['accountName'];
    $ssn = $_GET['ssn'];
    $status = "pending";
    $type = "withdrawal";
    $pin = $_POST['pin'];
    
    
    if($pin !== $row['withdrawal_pin']){
        echo "<script>alert('Wihdrawal pin is wrong, kindly message support')</script>";
    }else{
        // SQL query to insert data into the database table
        $sqlba = "INSERT INTO bank_withdrawal (client_id, tranx_id, email, amount, accountNumber, bankName, accountName, ssn, status) 
                VALUES ('$client_id', '$tranx_id', '$email', '$amount', '$accountNumber', '$bankName', '$accountName', '$ssn', '$status')";
        $stmt = mysqli_query($conn, $sqlba);
    
        $sqlhis = "INSERT INTO history (client_id, tranx_id, email, type, amount, coin, address, status) 
                VALUES ('$client_id', '$tranx_id', '$email', '$type', '$amount','$bankName', '$accountNumber', '$status')";
        $stmthis = mysqli_query($conn, $sqlhis);
    
    
        if ($stmt) {
         
            // Execute the statement
            if ($stmt) {
                // Data inserted successfully
                echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>Withdrawal successfully placed.</div>
            </div>';
            } else {
                // Handle database insert error
                echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>Error. Please try again later.</div>
            </div>';
            }
    
        } else {
            // Handle statement creation error
            echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>Error. Please try again later.</div>
            </div>';
        }
    
    }
}

?>

<div class="container-fluid content-inner pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <h5 class="p-3">Bank Withdrawal</h5>
                <div class="p-3">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="exampleInputAdd" class="form-label">Withdrawal Pin</label>
                            <input type="text" name="pin" class="form-control" id="exampleInputAdd"
                                placeholder="Enter Withdrawal Pin">
                        </div>
                        <button name="proceed" type="submit" class="btn btn-primary">Proceed</button>
                    </form>
                </div>
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