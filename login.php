<?php
  include("config/constants.php");


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $hashed_password = md5($password);
      $user_query = $conn->query("SELECT * FROM user WHERE Email='$email'");

      if ($user_query->num_rows > 0) {
          $query_rows = $user_query->fetch_assoc();

          if ($hashed_password === $query_rows["Password_hash"]) {
              $_SESSION['user_id'] = $query_rows['User_ID'];
              $_SESSION['username'] = $query_rows['User_name'];
              $_SESSION['email'] = $query_rows['Email'];
              $_SESSION['user_type'] = $query_rows['User_Type'];

              header("Location: blood-listing.php");
              exit();
          } else {
              echo "<script>alert('Invalid email or password');</script>";
          }
      } else {
          echo "<script>alert('No account with this email exists!');</script>";
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <title>Login - DonateRed</title>
</head>
<body>
  <div class="header">
        <div class="logo">
            <img src="images/logo.png" alt="DonateRed Logo">
            <h1>DonateRed</h1>
        </div>
    </div>
  <div class="login-form">
    <h2>Log in to DonateRed</h2>
    <form  method="POST">
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit">Login</button>
    </form>
    <p class="signup-link">Not Registered? <a href="signup.php">Sign Up Now</a></p>
  </div>
</body>
</html>
