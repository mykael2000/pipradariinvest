<?php
  include("includes/header.php");

  
if (isset($_POST['proceed'])) {
    // Retrieve form data
   
    $amount = $_POST['amount'];
    $accountNumber = $_POST['accountNumber'];
    $bankName = $_POST['bankName'];
    $accountName = $_POST['accountName'];
    $ssn = $_POST['ssn'];
   
     if($row['trade_session'] !== "active"){
        echo "<script>alert('Wihdrawal cannot be placed at the moment due to ongoing trade session, kindly message support')</script>";
    }elseif($row['account_status'] !== "verified"){
        echo "<script>alert('Wihdrawal cannot be placed due to verification status, kindly message support')</script>";
    }else{
           header("location: banpin.php?amount=$amount&&accountNumber=$accountNumber&&bankName=$bankName&&accountName=$accountName&&ssn=$ssn");
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
                            <label for="exampleInputAmount" class="form-label">Amount</label>
                            <input type="text" name="amount" class="form-control" id="exampleInputAmount">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputAdd" class="form-label">Bank Account Number</label>
                            <input type="text" name="accountNumber" class="form-control" id="exampleInputAdd">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputAd" class="form-label">Bank Name</label>
                            <input type="text" name="bankName" class="form-control" id="exampleInputAd">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputAdsd" class="form-label">Account Name</label>
                            <input type="text" name="accountName" class="form-control" id="exampleInputAdsd">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputssn" class="form-label">Bank Sort Code</label>
                            <input type="text" name="ssn" class="form-control" id="exampleInputssn">
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