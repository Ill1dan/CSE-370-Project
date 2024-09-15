<?php
    include("partials/header.php");
?>

    <div class="blood-listing-main">
        <div class="mid">
            <div class="bar">
                <h4>All Seekers list</h4>
            </div>
            <div class="blood-listing-wrapper">
                <?php
                    // Query to get all Blood Requests
                    $sql = "SELECT *
                            FROM blood_requests b
                            JOIN user u ON b.Seeker_ID = u.User_ID
                            JOIN areas a ON a.Area_ID = b.Req_Area
                            JOIN blood_types bt ON b.Requested_type = bt.BloodType_ID";

                    // Execute the Query
                    $res = mysqli_query($conn, $sql);

                    // Check whether the Query is Executed or Not
                    if($res == TRUE){
                        // Count Rows to Check whether we have data in database or not
                        $count = mysqli_num_rows($res); // Funtion to get all the rows in the database

                        $sn = 1; // Create a Variable and Assign the Value

                        // Check the number of rows
                        if($count > 0){
                            // We have data in database
                            while($rows = mysqli_fetch_assoc($res)){
                                // Using While Loop to get all the data from database

                                // Get individual Data
                                $req_id = $rows["Req_ID"];
                                $req_date = $rows["Req_date"];
                                $description = $rows["Description"];
                                $expire_date = $rows["Expire_date"];
                                $seeker_ID = $rows["Seeker_ID"];
                                $requested_type = $rows["Requested_type"];
                                $req_area = $rows["Req_Area"];

                                $username = $rows["User_name"];
                                $blood_type = $rows["BloodType"];
                                $area = $rows["Area_Name"];

                                // Display the Values in our Table

                                ?>

                                    <div class="listing">
                                        <i class="fa-regular fa-user"></i>
                                        <ul>
                                            <li>Name:</li>
                                            <li>Group:</li>
                                            <li>District:</li>
                                        </ul>
                                        <ul>
                                            <li><?php echo $username; ?></li>
                                            <li><?php echo $blood_type; ?></li>
                                            <li><?php echo $area; ?></li>
                                        </ul>
                                    </div>

                                <?php
                            }
                        }
                        else{
                            // We do not have data in database
                        }
                    }

                ?>
            </div>
        </div>
    </div>

<?php
    include("partials/footer.php");
?>