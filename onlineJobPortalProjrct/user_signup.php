<?php
    include("my_methods.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="newcss/user-signup.css">
</head>
<body>    
    <div class="container">
        <h1>Create an Account</h1>
        <div class="success-message" id="successMessage">
            Account created successfully!
        </div>
        <form id="signupForm" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="fullname" placeholder="Enter your full name" required>
                <div class="error" id="nameError">Please enter your name</div>
            </div>
            
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                    <option value="prefer-not-to-say">Prefer not to say</option>
                </select>
                <div class="error" id="genderError">Please select your gender</div>
            </div>
            
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="1" max="120" placeholder="Enter your age" required>
                <div class="error" id="ageError">Please enter a valid age (1-120)</div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                <div class="error" id="emailError">Please enter a valid email address</div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" placeholder="Create a password" minlength="8" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                <div class="error" id="passwordError">Password must be at least 8 characters</div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="password-toggle">
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    <i class="fas fa-eye" id="toggleConfirmPassword"></i>
                </div>
                <div class="error" id="confirmPasswordError">Passwords do not match</div>
            </div>

            <div class="form-group">
                <label for="profileImage">Profile Picture</label>
                <div class="image-upload-container">
                    <!-- <div class="image-preview" id="imagePreview">
                        <img src="" alt="Image Preview" class="image-preview__image">
                        <span class="image-preview__default-text">No image selected</span>
                    </div> -->
                    <!-- <label for="profileImage" class="image-upload-btn">
                        <i class="fas fa-camera"></i> Choose Image
                        <input type="file" id="profileImage" name="image" accept="image/*">
                    </label> -->
                    <input type="file" class="image-upload-btn" id="profileImage" name="image" accept="image/*">
                    <span class="error-message">Please select a valid image file (JPEG, PNG)</span>
                    
                </div>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="#">Terms and Conditions</a></label>
                <div class="error" id="termsError">You must agree to the terms</div>
            </div>
            
            <button type="submit" name="signup">Sign Up</button>
        </form>
    
        <div class="admin-link">
            <p>Need an admin account? <a href="admin_signup.php">Admin Signup</a></p>
        </div>
    </div>

    <?php
        if (isset($_POST['signup'])) {
            $response = upload_user_details($_POST);

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