<?php
    // Start Session
    session_start();

    // Create Constants to store non repeating values
    define("SITEURL", "http://localhost/370-project/");
    define("LOCALHOST", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "donatered");

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); // Database Connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // Selecting Database

?>