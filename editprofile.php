<?php
include("partials/header.php");


$user_id = $_SESSION['user_id'];
$user_table_query = $conn->query("SELECT * FROM user WHERE User_ID = $user_id");
$user_data = $user_table_query->fetch_assoc();

if ($user_data['User_type']=='Donor') {
    $isDonor = TRUE; 
    $donor_profile_query = $conn->query("SELECT * FROM donor_profile WHERE Donor_ID = $user_id");
    $donor_data = $donor_profile_query->fetch_assoc();

    $donor_areas = [];
    $donor_areas_query = $conn->query("SELECT Area_ID FROM donor_areas WHERE Donor_ID = $user_id");
    while ($donor_area_rows = $donor_areas_query->fetch_assoc()) {
        $donor_areas[] = $donor_area_rows['Area_ID'];
    }
}else{
    $isDonor = FALSE;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $firstname . " " . $lastname;
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    if (!empty($_POST['password'])) {
        $pwd = md5($_POST['password']);
        $user_upadate_query = $conn->query("UPDATE user SET First_name='$firstname', Last_name='$lastname', Email='$email', User_name='$username' ,Phone_num='$phone', Gender='$gender', Password_hash='$pwd' WHERE User_ID = $user_id");
    }
    else {
        $user_upadate_query = $conn->query("UPDATE user SET First_name='$firstname', Last_name='$lastname', Email='$email', User_name='$username' ,Phone_num='$phone', Gender='$gender' WHERE User_ID = $user_id");
    }
    if ($isDonor) {
        $bloodType = $_POST['bloodType'];
        $bloodtypeid_query = $conn->query("SELECT BloodType_ID FROM blood_types where BloodType='$bloodType'");
        $bloodtypeid= ($bloodtypeid_query->fetch_assoc())['BloodType_ID'];
        if (!empty($_POST['lastDonation'])) {
            $lastDonation = $_POST['lastDonation'];
        }else {
            $lastDonation = NULL;
        }
        $donor_update = $conn->query("UPDATE donor_profile SET BloodType_ID=$bloodtypeid, Last_dono_date='$lastDonation' WHERE Donor_ID = $user_id");
        $conn->query("DELETE FROM donor_areas WHERE Donor_ID = $user_id");
        $updated_donor_areas = $_POST['NewDonationArea'];
            foreach ($updated_donor_areas as $areaID) {
                $donor_areas= "INSERT INTO donor_areas (Donor_ID, Area_ID) VALUES ($user_id, $areaID)";
                $conn->query($donor_areas);
            }
    }
    header("Location:".SITEURL."blood-listing.php");

}

?>
    <div class="container">
        <div class="edit-profile-container">
            <h2>Edit Profile</h2>
            <form method="POST">
                <div class="input-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" value="<?= $user_data['First_name'] ?>" required>
                </div>
                <div class="input-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" value="<?= $user_data['Last_name'] ?>" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= $user_data['Email'] ?>" required>
                </div>
                <div class="input-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?= $user_data['Phone_num'] ?>" required>
                </div>
                <div class="input-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="male" <?= $user_data['Gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $user_data['Gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $user_data['Gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="Leave it blank if you want to keep current password">
                </div>

                <?php if ($isDonor): ?>
                <div class="donor-fields">
                    <h3>Donor Information</h3>
                    <div class="input-group">
                        <label for="bloodType">Blood Type</label>
                        <select id="bloodType" name="bloodType">
                            <option value="A+" <?= $donor_data['BloodType_ID'] == 1 ? 'selected' : '' ?>>A+</option>
                            <option value="A-" <?= $donor_data['BloodType_ID'] == 2 ? 'selected' : '' ?>>A-</option>
                            <option value="B+" <?= $donor_data['BloodType_ID'] == 3 ? 'selected' : '' ?>>B+</option>
                            <option value="B-" <?= $donor_data['BloodType_ID'] == 4 ? 'selected' : '' ?>>B-</option>
                            <option value="AB+" <?= $donor_data['BloodType_ID'] == 5 ? 'selected' : '' ?>>AB+</option>
                            <option value="AB-" <?= $donor_data['BloodType_ID'] == 6 ? 'selected' : '' ?>>AB-</option>
                            <option value="O+" <?= $donor_data['BloodType_ID'] == 7 ? 'selected' : '' ?>>O+</option>
                            <option value="O-" <?= $donor_data['BloodType_ID'] == 8 ? 'selected' : '' ?>>O-</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="donationArea">Preferred Donation Area</label>
                        <select id="donationArea" name="NewDonationArea[]" multiple>
                        <?php
                        $all_areas_query = $conn->query("SELECT Area_ID, Area_Name FROM areas");
                        while ($area_rows = $all_areas_query->fetch_assoc()) {
                            $selected = in_array($area_rows['Area_ID'], $donor_areas) ? 'selected' : '';
                            echo '<option value="' . $area_rows['Area_ID'] . '" ' . $selected . '>' . $area_rows["Area_Name"] . '</option>';
                        }
                        ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="lastDonation">Last Donation Date</label>
                        <input type="date" id="lastDonation" name="lastDonation" value="<?= $donor_data['Last_dono_date'] ?>">
                    </div>
                </div>
                <?php endif; ?>
                <div class='button-container'>
                    <button type="submit" name='UpdateProfile'>Update Profile</button>
                    <!-- <button class="delete-button" type="submit" name="deleteAccount" onclick="return confirm('This action will permanently delete your account. Are you sure you want to continue?');">Delete Account</button> -->
                </div>
            </form>
        </div>
    </div>

<?php
    include("partials/footer.php");
?>