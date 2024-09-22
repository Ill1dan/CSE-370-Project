<?php
    include("partials/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add-blood-request</title>
    <link rel="stylesheet" href="css/add-blood-request.css">
    <script>
        function req_togglePatientFields() {
        const patientSelect = document.getElementById('req-is-patient');
        const patientFields = document.getElementById('req-patient-fields');
        const patientInputs = patientFields.querySelectorAll('input, select');

        if (patientSelect.value === 'no') {
            // Show patient fields and make them required
            patientFields.classList.remove('req-hidden');
            patientInputs.forEach(input => {
                input.setAttribute('required', 'required');
            });
        } 
        else {
            // Hide patient fields and remove the required attribute
            patientFields.classList.add('req-hidden');
            patientInputs.forEach(input => {
                input.removeAttribute('required');
            });
        }
    }

        function req_validateForm(event) {
            const requiredFields = document.querySelectorAll('[required]');
            let valid = true;
            requiredFields.forEach(field => {
                if (!field.value) {
                    valid = false;
                }
            });
            if (!valid) {
                event.preventDefault();
                alert("Please fill required fields first.");
            }
        }

        function req_resetForm() {
            document.querySelector('form').reset();
            document.getElementById('req-patient-fields').classList.add('req-hidden');
        }
            
    </script>
</head>

<body>
    <div class="add-blood-request-main">
        <div class="req-form-container">
            <h2>Add your Blood Requests Here</h2>
            <br>
            <form action="blood-request-submit.php" method="POST" onsubmit="req_validateForm(event)">
                <label for="req-is-patient">Are you the patient? <span class="req-asterisk">*</span></label>
                <select id="req-is-patient" name="req-is-patient" onchange="req_togglePatientFields()" required>
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <div id="req-patient-fields" class="req-hidden">
                    <label for="req-patient-name">Patient Name: <span class="req-asterisk">*</span></label>
                    <input type="text" id="req-patient-name" name="req-patient-name" placeholder="Enter patient name" required>

                    <label for="req-patient-age">Patient Age: <span class="req-asterisk">*</span></label>
                    <input type="text" id="req-patient-age" name="req-patient-age" placeholder="Enter patient age" required>

                    <label for="req-patient-gender">Patient Gender: <span class="req-asterisk">*</span></label>
                    <select id="req-patient-gender" name="req-patient-gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="req-patient-phone">Patient Phone Number: <span class="req-asterisk">*</span></label>
                    <input type="text" id="req-patient-phone" name="req-patient-phone" placeholder="Enter phone number" required>
                </div>

                <label for="req-blood-group">Blood Group: <span class="req-asterisk">*</span></label>
                <select id="req-blood-group" name="req-blood-group" required>
                    <option value="">Select</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>

                <label for="req-needed-date">Blood Needed Date: <span class="req-asterisk">*</span></label>
                <input type="date" id="req-needed-date" name="req-needed-date" required>

                <label for="req-no-longer-needed-date">Blood No Longer Needed Date: <span class="req-asterisk">*</span></label>
                <input type="date" id="req-no-longer-needed-date" name="req-no-longer-needed-date" required>

                <label for="req-area">Area: <span class="req-asterisk">*</span></label>
                <select id="req-area" name="req-area" required>
                    <option value="">Select Area</option>
                    <option value="Banani">Banani</option>
                    <option value="Dhanmondi">Dhanmondi</option>
                    <option value="Gulshan">Gulshan</option>
                    <option value="Mirpur">Mirpur</option>
                    <option value="Mohammadpur">Mohammadpur</option>
                    <option value="Motijheel">Motijheel</option>
                    <option value="Shahbagh">Wari</option>
                    <option value="Tejgaon">Tejgaon</option>
                    <option value="Uttara">Uttara</option>

                </select>

                <label for="req-description">Description (optional):</label>
                <textarea id="req-description" name="req-description" placeholder="Add hospital name, disease, donation time etc."></textarea>

                <div style="display: flex; justify-content: space-between;">
                    <button type="submit">Submit</button>
                    <button type="button" onclick="req_resetForm()">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php
    include("partials/footer.php");
?>