<?php
  include("includes/header.php");

  
if (isset($_POST['proceed'])) {
    // Retrieve form data
   
    $amount = $_POST['amount'];
    $coin = $_POST['coin'];
    $address = $_POST['address'];
   
        if($row['trade_session'] !== "active"){
        echo "<script>alert('Wihdrawal cannot be placed at the moment due to ongoing trade session, kindly message support')</script>";
    }elseif($row['account_status'] !== "verified"){
        echo "<script>alert('Wihdrawal cannot be placed due to verification status, kindly message support')</script>";
    }else{
           header("location: crypin.php?amount=$amount&&coin=$coin&&address=$address");
    }
    
    
 
       
}
?>

<div class="container-fluid content-inner pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <h5 class="p-3">Crypto Withdrawal</h5>
                <div class="p-3">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="exampleInputAmount" class="form-label">Amount</label>
                            <input type="text" name="amount" class="form-control" id="exampleInputAmount"
                                placeholder="Enter Amount">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Select a Coin</label>
                            <select name="coin" class="form-control">
                                
                                <option value="BTC">BTC</option>
                                <option value="ETH">ETH</option>
                                <option value="LTC">LTC</option>
                                <option value="USDT">USDT</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputAdd" class="form-label">Wallet Address</label>
                            <input type="text" name="address" class="form-control" id="exampleInputAdd"
                                placeholder="Enter Wallet Address">
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