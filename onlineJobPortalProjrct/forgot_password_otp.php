<?php
    session_start();
    include("my_methods.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Verify OTP</title>
    <link rel="stylesheet" href="newcss/forgot_password_otp.css">
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-header">
            <div class="step-indicator">
                <div class="step completed">✓</div>
                <div class="step-line completed"></div>
                <div class="step active">2</div>
                <div class="step-line"></div>
                <div class="step">3</div>
            </div>
            <h1>Verify Code</h1>
            <p>We've sent a 6-digit verification code to<br><strong>your_email@example.com</strong></p>
        </div>
        
        <form class="forgot-form" action="" method="post">
            <div class="form-group">
                <label for="otp">Verification Code</label>
                <input type="text" id="otp" placeholder="Enter 6-digit code" name="otp" maxlength="6" pattern="[0-9]{6}">
                <small class="form-hint">Code expires in 10 minutes</small>
            </div>
            
            <button type="submit" class="submit-button" name="verifyOtp">Verify Code</button>
            
            <div class="resend-section">
                <p>Didn't receive the code?</p>
                <form method="post" style="display: inline;">
                    <button type="submit" class="resend-button" name="resendOtp">Resend Code</button>
                </form>
            </div>
        </form>
        
        <div class="forgot-footer">
            <p><a href="forgot_password_email.php">← Back to Email</a></p>
        </div>
    </div>

    <?php

        if(isset($_POST['verifyOtp'])) {
            $enteredOtp = $_POST['otp'];
        // echo "Entered OTP: " . $enteredOtp . "<br>"; (for debugging)
        // echo "Session OTP: " . $_SESSION['resetOtp'] . "<br>";
            $verifiedResponse = verifyOtp($enteredOtp);


            if($verifiedResponse == true) {
                echo "<script>
                    window.location.href='forgot_password_reset.php';
                </script>";
            } else {
                echo "<script>
                    alert('Invalid OTP. Please try again.');
                    window.location.href='forgot_password_otp.php';
                </script>";
            }
        }
    ?>

    <?php
        if(isset($_POST['resendOtp'])) {
            $response = resendEmail();

            if($response['success'] == true) {
                echo "<script>
                    alert('A new OTP has been sent to your email.');
                </script>";
            } else {
                echo "<script>
                    alert('Session expired. Please go back and enter your email again.');
                </script>";
            }
        }
    ?>
</body>
</html>
