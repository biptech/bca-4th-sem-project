<?php
include_once(__DIR__ . '/includes/config.php');

// Initialize variables to store user input and errors
$u_name = $u_address = $u_email = $u_phone = $u_gender = $u_password = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Function to sanitize input data
    function sanitizeInput($data) {
        global $con; // Access the database connection within this function
        return mysqli_real_escape_string($con, trim($data));
    }

    // Sanitize and validate each input field
    $u_name = sanitizeInput($_POST['u_name']);
    $u_address = sanitizeInput($_POST['u_address']);
    $u_email = sanitizeInput($_POST['u_email']);
    $u_phone = sanitizeInput($_POST['u_phone']);
    $u_gender = $_POST['u_gender']; // No need to sanitize as it's a select option
    $u_password = sanitizeInput($_POST['u_password']);

    // Example validation (add more as needed)
    if (empty($u_name)) {
        $errors[] = "Full Name is required.";
    }
    if (empty($u_email) || !filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid Email is required.";
    }
    if (empty($u_phone) || !preg_match('/^(98|97)[0-9]{8}$/', $u_phone)) {
        $errors[] = "Phone number must start with 98 or 97 and contain exactly 10 digits.";
    }
    if ($u_gender === 'Gender') {
        $errors[] = "Please select your gender.";
    }
    if (empty($u_password) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', $u_password)) {
        $errors[] = "Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.";
    }

    // If no errors, proceed to insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO user_signup (u_name, u_address, u_email, u_phone, u_gender, u_password)
                VALUES ('$u_name', '$u_address', '$u_email', '$u_phone', '$u_gender', '$u_password')";

        if (mysqli_query($con, $sql)) {
            // Display success message and redirect
            echo '<script type="text/javascript">
                    alert("Sign Up Successfully!\nNow Log in With Your Email and Password");
                    window.location.assign("login.php");
                  </script>';
            exit(); // Prevent further execution of PHP code
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }

    // Close connection (optional if not using persistent connection)
    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/ae61999827.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="js/main.js"></script>
    <link rel="stylesheet" href="css/signup.css">
    <style>
        .input-container {
            position: relative;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-size: 14px;
            position: absolute;
            top: -20px; /* Position above the input */
            width: 100%;
            text-align: center; /* Center-align the error message */
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="signup-body">
    <form action="sign-up.php" class="sign-up" method="POST" onsubmit="return validateForm()">
        <div class="sign-up-form">
            <p class="signup-txt"><i class="fa-solid fa-user-plus"></i> Sign Up</p>
            <div class="s-inputs">
                <div class="input-container">
                    <input type="text" name="u_name" id="u_name" placeholder="Full Name" value="<?php echo htmlspecialchars($u_name); ?>" required>
                    <div id="error_u_name" class="error"></div>
                </div>
                <div class="input-container">
                    <input type="text" name="u_address" id="u_address" placeholder="Address" value="<?php echo htmlspecialchars($u_address); ?>" required>
                    <div id="error_u_address" class="error"></div>
                </div>
                <div class="input-container">
                    <input type="text" name="u_email" id="u_email" placeholder="Email" value="<?php echo htmlspecialchars($u_email); ?>" required>
                    <div id="error_u_email" class="error"></div>
                </div>
                <div class="input-container">
                    <input type="text" name="u_phone" id="u_phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($u_phone); ?>" required>
                    <div id="error_u_phone" class="error"></div>
                </div>
                <div class="input-container">
                    <select name="u_gender" id="u_gender" required>
                        <option value="">Gender</option>
                        <option value="Male" <?php if ($u_gender === 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($u_gender === 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($u_gender === 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                    <div id="error_u_gender" class="error"></div>
                </div>
                <div class="input-container">
                    <input type="password" name="u_password" id="u_password" placeholder="New Password" required>
                    <div id="error_u_password" class="error"></div>
                </div>
                <div class="input-container">
                    <input type="password" name="u_cpassword" id="u_cpassword" placeholder="Confirm Password" required>
                    <div id="error_u_cpassword" class="error"></div>
                </div>
            </div>
            
            <input type="submit" name="submit" value="Sign Up">
            <p><a href="login.php">Already have an account</a></p>
        </div>
        <div class="sign-up-term-condition-text">
            <p>Full name can only contain letters and spaces. <br> Please enter your valid email address .....@gmail.com. <br> Phone number must start with 98 or 97 and contain exactly 10 digits. <br> Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.</p>
        </div>
        <div class="sign-up-term-condition-text">
            <p>By creating an account, You agree to our <a href="#">terms</a> and have read <a href="#">conditions</a>.</p>
        </div>
    </form>
</div>

<script>
    function validateForm() {
        var isValid = true;

        // Reset all error messages
        var errorElements = document.getElementsByClassName("error");
        for (var i = 0; i < errorElements.length; i++) {
            errorElements[i].textContent = '';
        }

        // Validate Full Name
        var u_name = document.getElementById("u_name").value.trim();
        if (u_name === '') {
            document.getElementById("error_u_name").textContent = 'Please enter your full name.';
            isValid = false;
        } else if (!/^(?:(?:Dr\.|Er\.|Mr\.|Mrs\.|Ms\.|Rev\.|PhD\.|MD\.)\s)?[a-zA-Z\.]{3,}(?:\s[a-zA-Z\.]{3,})*$/.test(u_name)) {
            document.getElementById("error_u_name").textContent = 'Please enter a valid name.';
            isValid = false;
        }

        // Validate Address
        var u_address = document.getElementById("u_address").value.trim();
        if (u_address === '') {
            document.getElementById("error_u_address").textContent = 'Please enter your address.';
            isValid = false;
        } else if (!/\b[a-zA-Z]{3,}\b/.test(u_address)) {
            document.getElementById("error_u_address").textContent = 'Please enter a valid address.';
            isValid = false;
        }

        // Validate Email
        var u_email = document.getElementById("u_email").value.trim();
        if (u_email === '') {
            document.getElementById("error_u_email").textContent = 'Please enter your email address.';
            isValid = false;
        } else if (!/^[a-zA-Z]+[a-zA-Z0-9._-]*@gmail\.com$/.test(u_email)) {
            document.getElementById("error_u_email").textContent = 'Please enter a valid email address.';
            isValid = false;
        }

        // Validate Phone Number
        var u_phone = document.getElementById("u_phone").value.trim();
        if (u_phone === '') {
            document.getElementById("error_u_phone").textContent = 'Please enter your phone number.';
            isValid = false;
        } else if (!/^(98|97)/.test(u_phone)) {
            document.getElementById("error_u_phone").textContent = 'Phone number must start with 98 or 97.';
            isValid = false;
        } else if (!/^[0-9]{10}$/.test(u_phone)){
            document.getElementById("error_u_phone").textContent = 'Phone number must be exactly 10 digits long.';
            isValid = false;
        }

        // Validate Gender
        var u_gender = document.getElementById("u_gender").value;
        if (u_gender === 'Gender') {
            document.getElementById("error_u_gender").textContent = 'Please select your gender.';
            isValid = false;
        }

        // Validate Password
        var u_password = document.getElementById("u_password").value.trim();
        if (u_password === '') {
            document.getElementById("error_u_password").textContent = 'Please enter a password.';
            isValid = false;
        } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(u_password)) {
            document.getElementById("error_u_password").textContent = 'Password requires lowercase, uppercase, digit, and special character.';
            isValid = false;
        }

        // Validate Confirm Password
        var u_cpassword = document.getElementById("u_cpassword").value.trim();
        if (u_cpassword === '') {
            document.getElementById("error_u_cpassword").textContent = 'Please confirm your password.';
            isValid = false;
        } else if (u_cpassword !== u_password) {
            document.getElementById("error_u_cpassword").textContent = 'Password and confirm password do not match.';
            isValid = false;
        }

        return isValid;
    }

    // Add event listeners to validate on input change
    document.getElementById("u_name").addEventListener('input', function() {
        validateName();
    });
    document.getElementById("u_address").addEventListener('input', function() {
        validateAddress();
    });
    document.getElementById("u_email").addEventListener('input', function() {
        validateEmail();
    });
    document.getElementById("u_phone").addEventListener('input', function() {
        validatePhone();
    });
    document.getElementById("u_gender").addEventListener('change', function() {
        validateGender();
    });
    document.getElementById("u_password").addEventListener('input', function() {
        validatePassword();
    });
    document.getElementById("u_cpassword").addEventListener('input', function() {
        validateConfirmPassword();
    });

    // Functions to validate each field individually
    function validateName() {
        var u_name = document.getElementById("u_name").value.trim();
        var errorElement = document.getElementById("error_u_name");
        errorElement.textContent = '';
        if (u_name === '') {
            errorElement.textContent = 'Please enter your full name.';
        } else if (!/^(?:(?:Dr\.|Er\.|Mr\.|Mrs\.|Ms\.|Rev\.|PhD\.|MD\.)\s)?[a-zA-Z\.]{3,}(?:\s[a-zA-Z\.]{3,})*$/.test(u_name)) {
            errorElement.textContent = 'Please enter a valid name.';
        }
    }

    function validateAddress() {
        var u_address = document.getElementById("u_address").value.trim();
        var errorElement = document.getElementById("error_u_address");
        errorElement.textContent = '';
        if (u_address === '') {
            errorElement.textContent = 'Please enter your address.';
        } else if (!/\b[a-zA-Z]{3,}\b/.test(u_address)) {
            errorElement.textContent = 'Please enter a valid address.';
        }
    }

    function validateEmail() {
        var u_email = document.getElementById("u_email").value.trim();
        var errorElement = document.getElementById("error_u_email");
        errorElement.textContent = '';
        if (u_email === '') {
            errorElement.textContent = 'Please enter your email address.';
        } else if (!/^[a-zA-Z]+[a-zA-Z0-9._-]*@gmail\.com$/.test(u_email)) {
            errorElement.textContent = 'Please enter a valid email address.';
        }
    }

    function validatePhone() {
    var u_phone = document.getElementById("u_phone").value.trim();
    var errorElement = document.getElementById("error_u_phone");
    errorElement.textContent = '';

    if (u_phone === '') {
        errorElement.textContent = 'Please enter your phone number.';
    } else if (!/^(98|97)/.test(u_phone)) {
        errorElement.textContent = 'Phone number must start with 98 or 97.';
    } else if (!/^[0-9]{10}$/.test(u_phone)) {
        errorElement.textContent = 'Phone number must be exactly 10 digits long.';
    }
}

    function validateGender() {
        var u_gender = document.getElementById("u_gender").value;
        var errorElement = document.getElementById("error_u_gender");
        errorElement.textContent = '';
        if (u_gender === 'Gender') {
            errorElement.textContent = 'Please select your gender.';
        }
    }

    function validatePassword() {
        var u_password = document.getElementById("u_password").value.trim();
        var errorElement = document.getElementById("error_u_password");
        errorElement.textContent = '';
        if (u_password === '') {
            errorElement.textContent = 'Please enter a password.';
        } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test(u_password)) {
            errorElement.textContent = 'Password requires lowercase, uppercase,digit, special char.';
        }
    }

    function validateConfirmPassword() {
        var u_password = document.getElementById("u_password").value.trim();
        var u_cpassword = document.getElementById("u_cpassword").value.trim();
        var errorElement = document.getElementById("error_u_cpassword");
        errorElement.textContent = '';
        if (u_cpassword === '') {
            errorElement.textContent = 'Please confirm your password.';
        } else if (u_cpassword !== u_password) {
            errorElement.textContent = 'Password and confirm password do not match.';
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>