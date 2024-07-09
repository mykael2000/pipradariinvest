<?php
include("includes/connection.php");
ob_start();
session_start();

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pipradariinvest</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" href="assets/css/libs.min.css" />
    <link rel="stylesheet" href="assets/css/style.css?v=1.0.0" />
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
    /* Styles for the overlay container */
    .overlay-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(61, 60, 70, 0.9);
        z-index: 1000;
    }

    /* Styles for the message box */
    .message-box {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #32313b;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 90%;
        text-align: center;
    }

    /* Styles for the action button */
    .action-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Styles for the close button */
    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
    </style>
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>

        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js"
            async>
        {
            "symbols": [{
                    "proName": "FOREXCOM:SPXUSD",
                    "title": "S&P 500"
                },
                {
                    "proName": "FOREXCOM:NSXUSD",
                    "title": "US 100"
                },
                {
                    "proName": "FX_IDC:EURUSD",
                    "title": "EUR to USD"
                },
                {
                    "proName": "BITSTAMP:BTCUSD",
                    "title": "Bitcoin"
                },
                {
                    "proName": "BITSTAMP:ETHUSD",
                    "title": "Ethereum"
                }
            ],
            "showSymbolLogo": true,
            "colorTheme": "dark",
            "isTransparent": true,
            "displayMode": "adaptive",
            "locale": "en"
        }
        </script>
    </div>
    <!-- TradingView Widget END -->
    <aside class="sidebar sidebar-default navs-rounded">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="https://pipradariinvest.org"
                class="navbar-brand dis-none align-items-center justify-content-center">
                <img height="100%" width="100%" src="logo.png">
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="https://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                            stroke-width="1.5"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body p-0 data-scrollbar">
            <div class="collapse navbar-collapse pe-3" id="sidebar">
                <ul class="navbar-nav iq-main-menu">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="main.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 30 30" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path
                                        d="M9.15722 20.7714V17.7047C9.1572 16.9246 9.79312 16.2908 10.581 16.2856H13.4671C14.2587 16.2856 14.9005 16.9209 14.9005 17.7047V17.7047V20.7809C14.9003 21.4432 15.4343 21.9845 16.103 22H18.0271C19.9451 22 21.5 20.4607 21.5 18.5618V18.5618V9.83784C21.4898 9.09083 21.1355 8.38935 20.538 7.93303L13.9577 2.6853C12.8049 1.77157 11.1662 1.77157 10.0134 2.6853L3.46203 7.94256C2.86226 8.39702 2.50739 9.09967 2.5 9.84736V18.5618C2.5 20.4607 4.05488 22 5.97291 22H7.89696C8.58235 22 9.13797 21.4499 9.13797 20.7714V20.7714"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="deposit.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 30 30" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9849 15.3462C8.11731 15.3462 4.81445 15.931 4.81445 18.2729C4.81445 20.6148 8.09636 21.2205 11.9849 21.2205C15.8525 21.2205 19.1545 20.6348 19.1545 18.2938C19.1545 15.9529 15.8735 15.3462 11.9849 15.3462Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9849 12.0059C14.523 12.0059 16.5801 9.94779 16.5801 7.40969C16.5801 4.8716 14.523 2.81445 11.9849 2.81445C9.44679 2.81445 7.3887 4.8716 7.3887 7.40969C7.38013 9.93922 9.42394 11.9973 11.9525 12.0059H11.9849Z"
                                        stroke="currentColor" stroke-width="1.42857" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Deposit now</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="withdrawal.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M14.5 10.5005C14.5 9.11924 13.3808 8 12.0005 8C10.6192 8 9.5 9.11924 9.5 10.5005C9.5 11.8808 10.6192 13 12.0005 13C13.3808 13 14.5 11.8808 14.5 10.5005Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9995 21C10.801 21 4.5 15.8984 4.5 10.5633C4.5 6.38664 7.8571 3 11.9995 3C16.1419 3 19.5 6.38664 19.5 10.5633C19.5 15.8984 13.198 21 11.9995 21Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Withdraw funds</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="depoHistory.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.739 6.15368C19.739 3.40281 17.8583 2.30005 15.1506 2.30005H8.79167C6.16711 2.30005 4.2002 3.32762 4.2002 5.97022V20.694C4.2002 21.4198 4.98115 21.877 5.61373 21.5221L11.9957 17.9422L18.3225 21.5161C18.9561 21.873 19.739 21.4158 19.739 20.689V6.15368Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M8.27148 9.02811H15.5898" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Deposit History</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.739 6.15368C19.739 3.40281 17.8583 2.30005 15.1506 2.30005H8.79167C6.16711 2.30005 4.2002 3.32762 4.2002 5.97022V20.694C4.2002 21.4198 4.98115 21.877 5.61373 21.5221L11.9957 17.9422L18.3225 21.5161C18.9561 21.873 19.739 21.4158 19.739 20.689V6.15368Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M8.27148 9.02811H15.5898" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Transaction History</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="upgrade.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 30 30" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9849 15.3462C8.11731 15.3462 4.81445 15.931 4.81445 18.2729C4.81445 20.6148 8.09636 21.2205 11.9849 21.2205C15.8525 21.2205 19.1545 20.6348 19.1545 18.2938C19.1545 15.9529 15.8735 15.3462 11.9849 15.3462Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9849 12.0059C14.523 12.0059 16.5801 9.94779 16.5801 7.40969C16.5801 4.8716 14.523 2.81445 11.9849 2.81445C9.44679 2.81445 7.3887 4.8716 7.3887 7.40969C7.38013 9.93922 9.42394 11.9973 11.9525 12.0059H11.9849Z"
                                        stroke="currentColor" stroke-width="1.42857" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Upgrade Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="withdrawal_pin.php">
                            <i class="icon">
                                <svg width="22" viewBox="0 0 30 30" fill="none" xmlns="https://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9849 15.3462C8.11731 15.3462 4.81445 15.931 4.81445 18.2729C4.81445 20.6148 8.09636 21.2205 11.9849 21.2205C15.8525 21.2205 19.1545 20.6348 19.1545 18.2938C19.1545 15.9529 15.8735 15.3462 11.9849 15.3462Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9849 12.0059C14.523 12.0059 16.5801 9.94779 16.5801 7.40969C16.5801 4.8716 14.523 2.81445 11.9849 2.81445C9.44679 2.81445 7.3887 4.8716 7.3887 7.40969C7.38013 9.93922 9.42394 11.9973 11.9525 12.0059H11.9849Z"
                                        stroke="currentColor" stroke-width="1.42857" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            <span class="item-name">Withdrawal pin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="profile.php">
                            <i class="icon">
                                <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-gear" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                    <path
                                        d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                                </svg>
                            </i>
                            <span class="item-name">Profile Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kyc.php">
                            <i class="icon">
                                <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                </svg>
                            </i>
                            <span class="item-name">Verify Account</span></a>
                    </li>

                </ul>
            </div>
            <div id="sidebar-footer" class="position-relative sidebar-footer">
                <div class="card mx-4">
                    <div class="card-body">
                        <div class="sidebarbottom-content">
                            <div class="image">
                                <img src="assets/images/coins/13.png" alt="User-Profile" class="img-fluid" />
                            </div>
                            <p class="mb-0">Be more secure with Pro Feature</p>
                            <button type="button" class="btn btn-primary mt-3">
                                Upgrade Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <main class="main-content">
        <div class="position-relative">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar border-bottom">
                <div class="container-fluid navbar-inner">
                    <a href="main.php" class="navbar-brand"> </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon">
                            <svg width="20px" height="20px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <h6 class="title">Dashboard</h6>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <span class="navbar-toggler-bar bar1 mt-2"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto navbar-list mb-2 mb-lg-0 align-items-center">
                            <!-- <li class="nav-item dropdown">
                                <a href="#" class="nav-link" id="notification-drop" data-bs-toggle="dropdown">
                                    <svg width="22" viewBox="0 0 22 22" fill="none" xmlns="https://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12 17.8476C17.6392 17.8476 20.2481 17.1242 20.5 14.2205C20.5 11.3188 18.6812 11.5054 18.6812 7.94511C18.6812 5.16414 16.0452 2 12 2C7.95477 2 5.31885 5.16414 5.31885 7.94511C5.31885 11.5054 3.5 11.3188 3.5 14.2205C3.75295 17.1352 6.36177 17.8476 12 17.8476Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M14.3889 20.8572C13.0247 22.3719 10.8967 22.3899 9.51953 20.8572"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="bg-danger dots"></span>
                                </a>
                                <div class="sub-drop dropdown-menu iq-noti dropdown-menu-end p-0"
                                    aria-labelledby="notification-drop">
                                    <div class="card shadow-none m-0">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <p class="fs-6">New notifications.</p>
                                            </div>
                                            <div class="header-title">
                                                <p class="fs-6">Mark all</p>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <a href="#" class="iq-sub-card">
                                                <div class="d-flex">
                                                    <img src="assets/images/utilities/05.png"
                                                        class="img-fluid avatar avatar-30 avatar-rounded" alt="img51" />
                                                    <div class="ms-3 w-100">
                                                        <h6 class="mb-0">
                                                            Successfull transaction og 0.01 BTC
                                                        </h6>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">15 mins ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="iq-sub-card">
                                                <div class="d-flex align-items-center">
                                                    <div class="">
                                                        <img src="assets/images/utilities/03.png"
                                                            class="img-fluid avatar avatar-30 avatar-rounded"
                                                            alt="img52" />
                                                    </div>
                                                    <div class="ms-3 w-100">
                                                        <h6 class="mb-0">4 of Pending Transactions!</h6>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">30 mins ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="iq-sub-card">
                                                <div class="d-flex align-items-center">
                                                    <img src="assets/images/utilities/04.png"
                                                        class="img-fluid avatar avatar-30 avatar-rounded" alt="img53" />
                                                    <div class="ms-3 w-100">
                                                        <h6 class="mb-0">Cancelled order of 2000 ICO</h6>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">55 mins ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="iq-sub-card">
                                                <div class="d-flex align-items-center">
                                                    <img src="assets/images/utilities/05.png"
                                                        class="img-fluid avatar avatar-30 avatar-rounded" alt="img54" />
                                                    <div class="w-100 ms-3">
                                                        <h6 class="mb-0">
                                                            Great speed notify of 1.34 LTC
                                                        </h6>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">14 Mar</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                            <!-- <li class="nav-item dropdown">
                                <a href="#" class="nav-link" id="mail-drop" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <svg width="22" viewBox="0 0 24 24" fill="none" xmlns="https://www.w3.org/2000/svg">
                                        <path
                                            d="M17.9028 8.85107L13.4596 12.4641C12.6201 13.1301 11.4389 13.1301 10.5994 12.4641L6.11865 8.85107"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.9089 21C19.9502 21.0084 22 18.5095 22 15.4384V8.57001C22 5.49883 19.9502 3 16.9089 3H7.09114C4.04979 3 2 5.49883 2 8.57001V15.4384C2 18.5095 4.04979 21.0084 7.09114 21H16.9089Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="bg-primary count-mail"></span>
                                </a>
                                <div class="sub-drop dropdown-menu dropdown-menu-end p-0" aria-labelledby="mail-drop">
                                    <div class="card shadow-none m-0">
                                        <div class="card-header d-flex justify-content-between py-3">
                                            <div class="header-title">
                                                <p class="mb-0 text-white">Our Latest News</p>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <a href="#" class="iq-sub-card">
                                                <div class="d-flex">
                                                    <div class="">
                                                        <img src="assets/images/coins/02.png"
                                                            class="img-fluid avatar avatar-50 avatar-rounded"
                                                            alt="img55" />
                                                    </div>
                                                    <div class="w-100 ms-3">
                                                        <h6 class="mb-0">Bitcoin</h6>
                                                        <small class="float-left font-size-12">Lorem Ipsum is simply
                                                            dummy text of the
                                                            printing and typesetting industry.
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </li> -->
                            <li class="nav-item dropdown">
                                <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php if(empty($row['profilePic'])){echo 'assets/images/avatars/01.png';}else{echo $row['profilePic'];} ?>"
                                        alt="User-Profile" class="img-fluid avatar avatar-50 avatar-rounded" />
                                    <div class="caption ms-3">
                                        <h6 class="mb-0 caption-title">
                                            <?php echo $row['firstname'].' '.$row['lastname']; ?></h6><button
                                            class="badge rounded-pill <?php if($row['account_status'] == 'verified'){echo 'bg-success';}else{echo 'bg-danger';} ?>"><?php echo $row['account_status']; ?></button>

                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li class="border-0">
                                        <a class="dropdown-item" href=""><i class="bi bi-person"></i><span
                                                style="padding-left: 5px;"><?php echo $row['email'];  ?></span></a>
                                    </li>
                                    <li class="border-0">
                                        <a class="dropdown-item" href="profile.php"><i class="bi bi-gear"></i><span
                                                style="padding-left: 5px;">Profile
                                                settings</span></a>
                                    </li>
                                    <!-- <li class="border-0">
                                        <a class="dropdown-item"
                                            href="dashboard/app/user-privacy-setting.html">Privacy Setting</a>
                                    </li> -->
                                    <li class="border-0">
                                        <hr class="m-0 dropdown-divider" />
                                    </li>
                                    <li class="border-0">
                                        <a class="dropdown-item" href="logout.php"><i
                                                class="bi bi-box-arrow-left"></i><span
                                                style="padding-left: 5px;">Logout</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!--Nav End-->
        </div>