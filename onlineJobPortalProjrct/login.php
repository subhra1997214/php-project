<?php
    session_start();
    include("my_methods.php");

    //getLoginInfo();
    $email = "";

    if(isset($_COOKIE['remember_email'])) {
    
        $email = $_COOKIE['remember_email'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="newcss/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please enter your details to log in</p>
        </div>
        
        <form class="login-form" action="" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your email" name="email" value="<?php echo $email; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter your password" name="password" required>
            </div>
            
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" <?php echo isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
                    <label for="remember">Remember me</label>
                </div>
                <a href="forgot_password_email.php" class="forgot-password">Forgot password?</a>
            </div>
            
            <button type="submit" class="login-button" name="login">Log In</button>
        </form>
        
        <div class="login-footer">
        <p>Don't have an account? <a href="user_signup.php">Sign up</a></p>
        </div>
    </div>

    <?php
        if(isset($_POST['login'])) {
            $role = login($_POST);
            //echo "<script>alert('".$role."');</script>";
            if($role != false) {
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['role'] = $role; 

                if ($role == 'admin') {
                    header("location:admin_dashboard.php");
                    exit();
                } else if ($role == 'user') {
                    header("location:user_dashboard.php");
                    exit();
                } else {
                    echo "<script>alert('Unknown role.');</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password');</script>";
            }
        }

    ?>
</body>
</html>