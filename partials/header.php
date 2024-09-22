<?php
    include("config/constants.php");
    include("login-checker.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonateRed</title>
    <link rel="stylesheet" href="css/body.css">
    <script src="https://kit.fontawesome.com/8a0d75a546.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="images/logo.png" alt="">
            <h1>DonateRed</h1>
        </div>
        
        <ul>
            <li><a href="blood-listing.php">Home</a></li>
            <li><a href="blood-listing.php">About Us</a></li>
            <li><a href="blood-listing.php">Search Listing</a></li>
            <li><a href="add-blood-request.php">Add Blood Request</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <div class="user-utilities">
            <a href="notification.php">
                <div class="user-notification-logo">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </a>
            <div>
                <a href="editprofile.php">
                    <div class="user-profile-logo">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </a>
                <h3><?php echo $_SESSION['username']; ?></h3>
            </div>
            

        </div>
    </div>