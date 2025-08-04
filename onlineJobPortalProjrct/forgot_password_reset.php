<?php
    session_start();
    include("my_methods.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Reset</title>
    <link rel="stylesheet" href="newcss/forgot_password_reset.css">
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-header">
            <div class="step-indicator">
                <div class="step completed">✓</div>
                <div class="step-line completed"></div>
                <div class="step completed">✓</div>
                <div class="step-line completed"></div>
                <div class="step active">3</div>
            </div>
            <h1>Create New Password</h1>
            <p>Your password must be at least 8 characters long</p>
        </div>
        
        <form class="forgot-form" action="" method="post">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" placeholder="Enter new password" name="newPassword" minlength="8" required>
                <small class="form-hint">Minimum 8 characters</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" placeholder="Confirm new password" name="confirmPassword" minlength="8" required>
                <small class="form-hint">Must match the password above</small>
            </div>
            
            <div class="password-requirements">
                <h4>Password Requirements:</h4>
                <ul>
                    <li>At least 8 characters long</li>
                    <li>Contains uppercase and lowercase letters</li>
                    <li>Contains at least one number</li>
                    <li>Contains at least one special character</li>
                </ul>
            </div>
            
            <button type="submit" class="submit-button" name="resetPassword">Reset Password</button>
        </form>
        
        <div class="forgot-footer">
            <p><a href="forgot_password_otp.php">← Back to Verification</a></p>
        </div>
    </div>

    <?php
        if(isset($_POST['resetPassword'])) {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            $resetPasswordResponse = createNewPassword($newPassword, $confirmPassword);

            if($resetPasswordResponse["success"]) {
                echo "
                    <script>
                        alert('Password reset successfully. Please login.');
                        window.location.href='login.php';
                    </script>
                ";
            } else {
                $msg = addslashes($resetPasswordResponse["error"] ?? "An unknown error occurred.");
                echo "
                    <script>
                        alert('$msg');
                    </script>
                ";
            }
        }
    ?>
</body>
</html>
