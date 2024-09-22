<?php
    include("config/constants.php");
    include("partials/login-checker.php");

// Getting data from the add-blood-request Form
$is_patient = $_POST['req-is-patient'];

if ($is_patient === 'yes') {
    $patient_name = null;
    $patient_age = null;
    $patient_gender = null;
    $patient_phone = null;
} else {
    $patient_name = $_POST['req-patient-name'] ?? null;
    $patient_age = $_POST['req-patient-age'] ?? null;
    $patient_gender = $_POST['req-patient-gender'] ?? null;
    $patient_phone = $_POST['req-patient-phone'] ?? null;
}

$blood_group = $_POST['req-blood-group'];
$req_date = $_POST['req-needed-date'];
$expire_date = $_POST['req-no-longer-needed-date'];
$req_area = $_POST['req-area'];
$description = !empty($_POST['req-description']) ? $_POST['req-description'] : 'No extra information provided. ';
$seeker_id = $_SESSION['user_id'];

// echo $description;

// Finding Area ID from query
$stmt = $conn->prepare("SELECT Area_ID FROM Areas WHERE Area_Name = ?");
$stmt->bind_param("s", $req_area);
$stmt->execute();
$result = $stmt->get_result();
$area_id = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $area_id = $row['Area_ID'];
} else {
    die("No matching area found.<br>");
}

$stmt->close();

// Finding Blood Type ID from query
$stmt = $conn->prepare("SELECT BloodType_ID FROM Blood_Types WHERE BloodType = ?");
$stmt->bind_param("s", $blood_group);
$stmt->execute();
$result = $stmt->get_result();
$requested_type = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $requested_type = $row['BloodType_ID'];
} else {
    die("No matching blood type found.<br>");
}

$stmt->close();

// Inserting values to Blood_Requests Table
$stmt = $conn->prepare("
    INSERT INTO Blood_Requests (Is_patient, Patient_name, Patient_age, Patient_gender, Patient_phone, Requested_type, Req_date, Expire_date, Req_area, Description, Seeker_ID) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param("ssisissssss", $is_patient, $patient_name, $patient_age, $patient_gender, $patient_phone, $requested_type, $req_date, $expire_date, $area_id, $description, $seeker_id);

if ($stmt->execute()) {
    echo "Blood request added successfully.<br>";
} else {
    die("Error adding blood request: " . $stmt->error . "<br>");
}

$stmt->close();


$seeker_name = $_SESSION['username'];  // Corrected key
$seeker_email = $_SESSION['email'];     // Corrected key

// Finding user's/seeker's phone number from query
$stmt = $conn->prepare("SELECT Phone_num FROM user WHERE User_id = ?");
$stmt->bind_param("s", $seeker_id);
$stmt->execute();
$result = $stmt->get_result();
$seeker_phone = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $seeker_phone = $row['Phone_num'];
} else {
    die("No matching phone number found.<br>");
}

$stmt->close();

// echo $seeker_name;
// echo $seeker_phone;
// echo $seeker_email;

// if (!isset($_SESSION['user_name']) || !isset($_SESSION['phone_num']) || !isset($_SESSION['email'])) {
//     die("Seeker information is missing in the session.");
// }

// Query to Find Matching Donors based on Blood Type ID and Area ID
$query = "
    SELECT dp.Donor_ID, bt.BloodType, a.Area_Name
    FROM DONOR_PROFILE dp
    INNER JOIN Donor_Areas da ON dp.Donor_ID = da.Donor_ID
    INNER JOIN Blood_Types bt ON dp.BloodType_ID = bt.BloodType_ID
    INNER JOIN Areas a ON da.Area_ID = a.Area_ID
    WHERE dp.BloodType_ID = ? 
      AND da.Area_ID = ? 
      AND dp.Donor_ID != ?
";


$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $requested_type, $area_id, $seeker_id);
$stmt->execute();
$result = $stmt->get_result();

// Getting Data for all Matched Donors and Creating Notifications
while ($row = $result->fetch_assoc()) {
    $donor_id = $row['Donor_ID'];
    $donor_blood_type = $row['BloodType'];
    $area_name = $row['Area_Name'];

    // Update Description if the user is not the patient
    $final_description = $description;
    if ($is_patient === 'no') {
        $final_description .= "\nAdditional Details :- Patient Name: $patient_name\n";
        $final_description .= ", Patient Age: $patient_age\n";
        $final_description .= ", Patient Gender: $patient_gender\n";
        $final_description .= ", Patient Phone: $patient_phone\n";
    }

    // Notification content ; later the details will be shown on notification page
    $notif_content = "
        Seeker Information:
        SeekerN: $seeker_name
        SeekerP: $seeker_phone
        Email: $seeker_email
        Blood Group: $donor_blood_type
        Request Area: $area_name
        Request Date: $req_date
        Expire Date: $expire_date   
        Description: $final_description
    ";

    // Inserting values to Notifications Table
    $insert_query = "
        INSERT INTO Notifications (Notif_Type, Content, Receiver_ID, Seeker_ID)
        VALUES ('DonorInfo', ?, ?, ?)
    ";

    $insert_stmt = $conn->prepare($insert_query);

    if ($insert_stmt) { // checks if the $insert_stmt variable is valid or not
        $insert_stmt->bind_param("sii", $notif_content, $donor_id, $seeker_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    } else {
        die("Failed to prepare insert statement: " . $conn->error);
    }
    
    // if ($insert_stmt) {  

    //     $insert_stmt->bind_param("sii", $notif_content, $donor_id, $seeker_id);
    //     if ($insert_stmt->execute()) {
    //         echo "Notification added for donor ID: $donor_id<br>";
    //     } else {
    //         echo "Error adding notification: " . $insert_stmt->error . "<br>";
    //     }
    //     $insert_stmt->close();
    // } else {
    //     die("Failed to prepare insert statement: " . $conn->error);
    // }
}

$stmt->close();

header("Location:".SITEURL."blood-listing.php");
exit();

$conn->close();

?>
