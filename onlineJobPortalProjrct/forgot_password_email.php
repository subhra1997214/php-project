<?php
    session_start();
    include("my_methods.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Email</title>
    <link rel="stylesheet" href="newcss/forgot_password_email.css">
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-header">
            <div class="step-indicator">
                <div class="step active">1</div>
                <div class="step-line"></div>
                <div class="step">2</div>
                <div class="step-line"></div>
                <div class="step">3</div>
            </div>
            <h1>Forgot Password?</h1>
            <p>Enter your email address and we'll send you a verification code</p>
        </div>
        
        <form class="forgot-form" action="" method="post">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" placeholder="Enter your registered email" name="email" required>
            </div>
            
            <button type="submit" class="submit-button" name="sendOtp">Send Verification Code</button>
        </form>
        
        <div class="forgot-footer">
            <p>Remember your password? <a href="login.php">Back to Login</a></p>
        </div>
    </div>

    <?php
        if(isset($_POST['sendOtp'])) {
            $email = trim($_POST['email']);

            $response = sendEmail($email);

            if($response["success"]) {
                echo "<script>
                    alert('OTP sent to your email.');
                    window.location.href='forgot_password_otp.php';
                </script>";
            } else {
                $msg = addslashes($response["error"]);
                echo "<script>
                    alert('Failed to send OTP. $msg');
                    window.location.href='forgot_password_email.php';
                </script>";
            }
        }
    ?>
</body>
</html>
