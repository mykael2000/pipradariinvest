<?php
ob_start();
session_start();

include("../includes/connection.php");


    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Query to fetch user details based on email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set up a session
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            $code = rand(1000,9999);
            
            // Redirect to the dashboard or another secure page
            header("location: ../2fa.php?email=$email&id=$code");
            exit();
        } else {
            echo '<div>Incorrect password. Please try again.</div>';
            header("refresh:1;url=../../login.html");
        }
    } else {
        echo  '<div>User not found.</div>';
        header("refresh:1;url=../../login.html");
    }

    $conn->close();

?>
