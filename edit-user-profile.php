<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/ae61999827.js"></script>
    <title>Edit Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .heading {
            margin-top: 5%;
            overflow: hidden;
        }

        .edit-profile {
            background: #f5f5f5;
            padding: 20px;
        }

        .edit-profile .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .edit-profile .heading span {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .edit-profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            border-radius: 10px;
        }

        .profile-detail {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .profile-detail label {
            font-weight: bold;
            color: black;
        }

        .profile-detail input,
        .profile-detail select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .profile-detail input[type="password"] {
            width: 100%;
        }

        .saveorcancel {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .save-btn, .cancel-btn {
            text-align: center;
            padding: 10px 20px;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .save-btn {
            background: #e56131;
            color: white;
        }

        .save-btn:hover {
            background: #000;
            color: white;
        }

        .cancel-btn {
            background: #000;
            color: white;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background: #e56131;
            color: white;
        }

        .save-btn button {
            border: none;
            background: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .cancel-btn a {
            color: white;
            font-size: 16px;
        }

        .cancel-btn a:hover {
            text-decoration: none;
            color: white;
            font-size: 16px;
        }

        .save-btn button i, .cancel-btn a i {
            margin-right: 5px;
        }

        .error {
            color: red;
            font-size: 12px;
            display: block; /* Ensure error messages are displayed as blocks */
            margin-top: -10px; /* Adjust margin to position above inputs */
        }
    </style>
</head>
<body>
    <!--Header-->
    <?php include 'includes/header.php'; ?>

    <?php
        $u_id = $_GET['u_id'];
        $qry = "SELECT * FROM user_signup WHERE u_id = '$u_id'";
        include 'includes/config.php';
        $result = mysqli_query($con, $qry);
        $row = mysqli_fetch_assoc($result);

        // Handle form submission
        if(isset($_POST['submit'])) {
            $u_name = mysqli_real_escape_string($con, $_POST['u_name']);
            $u_address = mysqli_real_escape_string($con, $_POST['u_address']);
            $u_email = mysqli_real_escape_string($con, $_POST['u_email']);
            $u_phone = mysqli_real_escape_string($con, $_POST['u_phone']);
            $u_gender = mysqli_real_escape_string($con, $_POST['u_gender']);
            $u_password = mysqli_real_escape_string($con, $_POST['u_password']);

            $qry2 = "UPDATE user_signup SET
                        u_name = '$u_name', 
                        u_address = '$u_address', 
                        u_email = '$u_email', 
                        u_phone = '$u_phone',
                        u_gender = '$u_gender',
                        u_password = '$u_password' 
                    WHERE u_id = '$u_id'";

            if(mysqli_query($con, $qry2)) {
                echo '<script type="text/javascript"> alert("Profile Updated Successfully"); window.location.assign("user-profile.php?u_id=' . $u_id . '");</script>';
                exit();
            } else {
                echo '<script type="text/javascript"> alert("Something Went Wrong!") </script>';
            }
        }
    ?> 

    <!--About-->
    <section class="edit-profile" id="edit-profile">
        <div class="heading">
            <span>Edit <?php echo $row['u_name'];?> Profile</span>
        </div>  
        <div class="edit-profile-container">
            <form action="" class="profile-detail" method="POST" onsubmit="return validateForm()">
                <div class="profile-edit-container">
                    <label for="u_name">Name:</label>
                    <span id="error_u_name" class="error"></span>
                    <input type="text" name="u_name" id="u_name" placeholder="Full Name" value="<?php echo $row['u_name'];?>" oninput="validateName()" onblur="validateName()"><br>

                    <label for="u_address">Address:</label>
                    <span id="error_u_address" class="error"></span>
                    <input type="text" name="u_address" id="u_address" placeholder="Address" value="<?php echo $row['u_address'];?>" oninput="validateAddress()" onblur="validateAddress()"><br>

                    <label for="u_email">Email:</label>
                    <span id="error_u_email" class="error"></span>
                    <input type="email" name="u_email" id="u_email" placeholder="Email" value="<?php echo $row['u_email'];?>" oninput="validateEmail()" onblur="validateEmail()"><br>

                    <label for="u_phone">Phone:</label>
                    <span id="error_u_phone" class="error"></span>
                    <input name="u_phone" id="u_phone" placeholder="Phone" value="<?php echo $row['u_phone'];?>" oninput="validatePhone()" onblur="validatePhone()"><br>

                    <label for="u_gender">Gender:</label>
                    <span id="error_u_gender" class="error"></span>
                    <select name="u_gender" id="u_gender" onchange="validateGender()" onblur="validateGender()">
                        <option value="Male" <?php if ($row['u_gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($row['u_gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($row['u_gender'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select><br>

                    <label for="u_password">Password:</label>
                    <span id="error_u_password" class="error"></span>
                    <input style="width: 100%;" type="password" name="u_password" id="u_password" placeholder="New Password" value="<?php echo $row['u_password'];?>" oninput="validatePassword()" onblur="validatePassword()"><br>

                    <div class="saveorcancel">
                        <div class="save-btn">
                            <button type="submit" name="submit" id="savebtn">
                                <i class="fa-solid fa-check"></i>
                                Save
                            </button>
                        </div>
                        <div class="cancel-btn">
                            <a href="user-profile.php?u_id=<?php echo $row['u_id']; ?>"><i class="fa-solid fa-xmark"></i> Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </section>

    <script>
        function validateName() {
            var u_name = document.getElementById("u_name").value.trim();
            if (u_name === '') {
                document.getElementById("error_u_name").textContent = 'Please enter your full name.';
                return false;
            } else if (!/^(?:(?:Dr\.|Er\.|Mr\.|Mrs\.|Ms\.|Rev\.|PhD\.|MD\.)\s)?[a-zA-Z\.]{3,}(?:\s[a-zA-Z\.]{3,})*$/.test(u_name)) {
                document.getElementById("error_u_name").textContent = 'Please enter a valid name.';
                return false;
            } else {
                document.getElementById("error_u_name").textContent = '';
                return true;
            }
        }

        function validateAddress() {
            var u_address = document.getElementById("u_address").value.trim();
            if (u_address === '') {
                document.getElementById("error_u_address").textContent = 'Please enter your address.';
                return false;
            } else if (!/\b[a-zA-Z]{3,}\b/.test(u_address)) {
                document.getElementById("error_u_address").textContent = 'Please enter a valid address.';
                return false;
            } else {
                document.getElementById("error_u_address").textContent = '';
                return true;
            }
        }

        function validateEmail() {
            var u_email = document.getElementById("u_email").value.trim();
            if (u_email === '') {
                document.getElementById("error_u_email").textContent = 'Please enter your email address.';
                return false;
            } else if (!/^[a-zA-Z]+[a-zA-Z0-9._-]*@gmail\.com$/.test(u_email)) {
                document.getElementById("error_u_email").textContent = 'Please enter a valid email address.';
                return false;
            } else {
                document.getElementById("error_u_email").textContent = '';
                return true;
            }
        }

        function validatePhone() {
            var u_phone = document.getElementById("u_phone").value.trim();
            if (u_phone === '') {
                document.getElementById("error_u_phone").textContent = 'Please enter your phone number.';
                return false;
            } else if (!/^(98|97)[0-9]{8}$/.test(u_phone)) {
                document.getElementById("error_u_phone").textContent = 'Phone number must start with 98 or 97 and contain exactly 10 digits.';
                return false;
            } else if (!/^[0-9]+$/.test(u_phone)) {
                document.getElementById("error_u_phone").textContent = 'Phone number can only contain numbers.';
                return false;
            } else {
                document.getElementById("error_u_phone").textContent = '';
                return true;
            }
        }

        function validateGender() {
            var u_gender = document.getElementById("u_gender").value;
            if (u_gender === 'Gender') {
                document.getElementById("error_u_gender").textContent = 'Please select your gender.';
                return false;
            } else {
                document.getElementById("error_u_gender").textContent = '';
                return true;
            }
        }

        function validatePassword() {
            var u_password = document.getElementById("u_password").value.trim();
            if (u_password === '') {
                document.getElementById("error_u_password").textContent = 'Please enter a password.';
                return false;
            } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(u_password)) {
                document.getElementById("error_u_password").textContent = 'Password requires lowercase, uppercase, digit, and special character.';
                return false;
            } else {
                document.getElementById("error_u_password").textContent = '';
                return true;
            }
        }

        function validateForm() {
            var isValid = true;

            if (!validateName()) {
                isValid = false;
            }

            if (!validateAddress()) {
                isValid = false;
            }

            if (!validateEmail()) {
                isValid = false;
            }

            if (!validatePhone()) {
                isValid = false;
            }

            if (!validateGender()) {
                isValid = false;
            }

            if (!validatePassword()) {
                isValid = false;
            }

            return isValid;
        }

        document.getElementById("u_name").addEventListener("input", validateName);
        document.getElementById("u_address").addEventListener("input", validateAddress);
        document.getElementById("u_email").addEventListener("input", validateEmail);
        document.getElementById("u_phone").addEventListener("input", validatePhone);
        document.getElementById("u_gender").addEventListener("change", validateGender);
        document.getElementById("u_password").addEventListener("input", validatePassword);
    </script>
</body>
</html>
