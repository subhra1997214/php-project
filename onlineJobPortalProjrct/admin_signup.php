<?php
    include("my_methods.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="newcss/admin-signup.css">
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h2>Admin Signup</h2>
            <p>Create your administrator account</p>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
            <!-- Full Name -->
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullname" placeholder="Enter your full name">
                <span class="error-message">Please enter your full name</span>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="gender" value="male" > Male
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="female"> Female
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="other"> Other
                    </label>
                </div>
                <span class="error-message">Please select your gender</span>
            </div>

            <!-- Age -->
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age" min="18">
                <span class="error-message">You must be at least 18 years old</span>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address">
                <span class="error-message">Please enter a valid email address</span>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" >
                </div>
                <span class="error-message">Password must be at least 8 characters with numbers and letters</span>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="password-container">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                           placeholder="Confirm your password">
                </div>
                <span class="error-message">Passwords do not match</span>
            </div>

            <!-- Profile Image Upload -->
            <div class="form-group">
                <label for="profileImage">Profile Image</label>
                <div class="image-upload-container">
                    <!-- <div class="image-preview">
                        <span class="image-preview__default-text">Image preview will appear here</span>
                    </div> -->
                    <input type="file" class="form-control" id="profileImage" name="image" accept="image/*">
                    <span class="error-message">Please select a valid image file (JPEG, PNG)</span>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="terms-checkbox">
                <input type="checkbox" id="termsCheck" name="termsCheck" required>
                <label for="termsCheck">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>
            <span class="error-message">You must agree to the terms and conditions</span>

            <!-- Submit Button -->
            <input type="submit" class="btn-submit" name="submit" value="Create Admin Account"></button>

            <div class="login-link">
                Already have an account? <a href="login.php">Log in</a>
            </div>
        </form>
    </div>

    <?php
        if(isset($_POST['submit'])) {
            $response = upload_admin_details($_POST);

           
            echo "
                <script>
                    alert('$response');
                    window.location.href = 'login.php';
                </script>
            ";
        }
    ?>
</body>
</html>