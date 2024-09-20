<?php
    // Authorization - Access Control

    // Check whether the user is logged in or not
    if(!isset($_SESSION["user_id"])){
        // User is logged in

        // Redirect to login page
        header("location:".SITEURL."login.php");
    }
    
?>