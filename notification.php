<?php
    include("partials/header.php");

$Seeker_ID = $_SESSION['user_id'];
$notifications = [];

// Query to fetch notifications for the logged-in user
$sql = "
    SELECT n.Content, n.Created_at,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'SeekerN: ', -1), '\n', 1) AS Seeker_Name,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'SeekerP: ', -1), '\n', 1) AS Seeker_Phone,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'Email: ', -1), '\n', 1) AS Email,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'Blood Group: ', -1), '\n', 1) AS BloodType,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'Request Area: ', -1), '\n', 1) AS Area_Name,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'Request Date: ', -1), '\n', 1) AS Req_date,
        SUBSTRING_INDEX(SUBSTRING_INDEX(n.Content, 'Expire Date: ', -1), '\n', 1) AS Expire_date,
        SUBSTRING_INDEX(n.Content, 'Description:', -1) AS Description
    FROM Notifications n
    WHERE n.Receiver_ID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Seeker_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

// echo '<pre>';
// print_r($notifications);
// echo '</pre>';

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notification</title>
    <link rel="stylesheet" href="css/notification.css">
    <script>
        function toggleDetails(button) {
            var details = button.nextElementSibling;
            if (details.style.display === "none") {
                details.style.display = "block";
                button.textContent = "Hide Details";
            } else {
                details.style.display = "none";
                button.textContent = "Show Details";
            }
        }
    </script>  
</head>

<body>
    <div class="notification-container">
        <?php
        if (empty($notifications)): ?>
            <div class="no-notification">
                <h2>No notifications found</h2>
            </div>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-card">
                    <h2>A new blood listing has just been added that perfectly aligns with your profile!<br>Would you like more details?</h2>
                    <button class="toggle-details-btn" onclick="toggleDetails(this)">Show Details</button>

                    <div class="details-section">
                        <div class="section-container">
                            <div class="section-icon">👤</div>
                            <div class="label">Seeker Name</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Seeker_Name']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">📞</div>
                            <div class="label">Phone Number</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Seeker_Phone']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">📧</div>
                            <div class="label">Email</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Email']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">🩸</div>
                            <div class="label">Blood Group</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['BloodType']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">📍</div>
                            <div class="label">Area</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Area_Name']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">📝</div>
                            <div class="label">Description</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Description']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">📅</div>
                            <div class="label">Requested on</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Req_date']); ?></strong></p>
                        </div>
                        <div class="section-container">
                            <div class="section-icon">⏳</div>
                            <div class="label">Expires on</div>
                            <div class="colon">:</div>
                            <p><strong><?php echo htmlspecialchars($notification['Expire_date']); ?></strong></p>
                        </div>
                    </div>

                    <p class="timestamp">Created at: <?php echo htmlspecialchars($notification['Created_at']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
    include("partials/footer.php");
?>