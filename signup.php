<?php
    include("config/constants.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $firstname . " " . $lastname;
        $email = $_POST["email"];
        $pwd = md5($_POST['password']);
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $isDonor = isset($_POST['isDonor']);
        $user_type = $isDonor ? "Donor" : "Seeker";

        $email_check = $conn->query("SELECT * FROM user where Email='$email';");
        if ($email_check->num_rows>0) {
            echo "<script>alert('Email is already in use');</script>";
        } else {
            $insetion_query = "INSERT INTO user (User_Type, User_name, Email, Password_hash, First_name, Last_name, DateofBirth, Phone_num, Gender) VALUES ('$user_type','$username', '$email','$pwd','$firstname', '$lastname','$dob','$phone','$gender')";
            if ($conn->query($insetion_query) === TRUE) {
                $user_id = $conn->insert_id;
            }
            if ($isDonor) {
                $bloodType = $_POST['bloodType'];
                echo "<script>console.log('Blood Type: $bloodType');</script>";
                $bloodtypeid_query = $conn->query("SELECT BloodType_ID FROM blood_types where BloodType='$bloodType'");
                $bloodtypeid= ($bloodtypeid_query->fetch_assoc())['BloodType_ID'];
                if (!empty($_POST['lastDonation'])) {
                    $lastDonation = $_POST['lastDonation'];
                }else {
                    $lastDonation = NULL;
                }
                $donor_profile_insertion = "INSERT INTO donor_profile (Donor_ID, BloodType_ID, Last_dono_date) VALUES ($user_id, $bloodtypeid, '$lastDonation')";
                $conn->query($donor_profile_insertion);
                $donationAreas = $_POST['donationArea'];
                foreach ($donationAreas as $areaID) {
                    $donor_areas= "INSERT INTO donor_areas (Donor_ID, Area_ID) VALUES ($user_id, $areaID)";
                    $conn->query($donor_areas);
                }
            }
        header("Location: login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign Up - DonateRed</title>
</head>
<body>
    <div class="logo-header">
        <img src="images/logo.png" alt="DonateRed Logo">
        <h1>DonateRed</h1>
    </div>
    <div class="signup-form">
        <h2>Create an account</h2>
        <form method="POST" id="signupForm">
            <div class="row">
                <div class="col">
                    <div class="input-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstname" required>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastname" required>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Create a password">
            </div>
            <div class="input-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="input-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required placeholder="+880XXXXXXXXXX">
            </div>
            <div class="input-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="isDonor" name="isDonor">
                <label for="isDonor" >I want to be a donor</label>
            </div>
            <div id="donorFields">
                <div class="input-group">
                    <label for="bloodType">Blood Type</label>
                    <select id="bloodType" name="bloodType">
                        <option value="">Select Blood Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="donationArea">Preferred Donation Area</label>
                    <select id="donationArea" name="donationArea[]" multiple>
                    <?php
                    $sql = "SELECT Area_ID, Area_Name FROM Areas";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["Area_ID"] . '">' . $row["Area_Name"] . '</option>';
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="lastDonation">Last Donation Date</label>
                    <input type="date" id="lastDonation" name="lastDonation">
                </div>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Login Now</a>
        </div>
    </div>
    <script>
        document.getElementById('isDonor').addEventListener('change', function() {
            document.getElementById('donorFields').style.display = this.checked ? 'block' : 'none';
        });
        document.getElementById('donationArea').addEventListener('change', function() {
            const options = this.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].selected) {
                    options[i].classList.add('selected');
                } else {
                    options[i].classList.remove('selected');
                }
            }
        });
    </script>
</body>
</html>