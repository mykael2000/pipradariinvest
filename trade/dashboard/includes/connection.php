<?php
// Database connection (Change credentials accordingly)
        $servername = "mysql.pipradariinvest.org";
        $username = "pipradariinvest";
        $password = "PswaRA@hfiy!";
        $dbname = "pipradariinvest";

        $conn = new mysqli($servername, $username, $password, $dbname);
        // if($conn){
        //     echo "connected successfully";
        // }else{
        //     echo "connection failed";
        // }