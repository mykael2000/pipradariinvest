<?php
  include("includes/header.php");
$method = "";

  if(isset($_POST['proceed'])){
    $method = $_POST['method'];

    if(empty($method)){
        echo "<script>alert('please select a withdrawal method')</script>";
    }elseif($method == 'crypto'){
        header("location: crypto.php");
    }elseif($method == 'bank'){
        header("location: bank.php");
    }
  }
?>

<div class="container-fluid content-inner pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <h5 class="p-3">Make a Withdrawal</h5>
                <div class="p-3">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Select a Withdrawal Method</label>
                            <select name="method" class="form-control">
                                <option value="" readonly>-- select --</option>
                                <option value="crypto">Crypto withdrawal</option>

                                <option value="bank">Bank withdrawal</option>

                            </select>
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