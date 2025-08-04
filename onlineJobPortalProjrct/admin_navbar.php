<?php
    include('my_methods.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Navbar</title>
    <link rel="stylesheet" href="newcss/admin-navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <?php
        session_start();

        if(!isset($_SESSION['email'])) {
            header('location:login.php');
        }

        $email = $_SESSION['email'];

        $details = getUserByEmail($email);

        $data = mysqli_fetch_assoc($details);
    ?>

    <nav class="navbar">
        <div class="navbar-brand">
            <a class="navbar-brand logo" href="index.php">
                <div class="logo">CareerConnect</div>
            </a>
        </div>

        <div class="navbar-links">
            <a href="index.php" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="admin_dashboard.php" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="admin_profile.php?check" class="nav-link">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="add_new_job.php" class="nav-link highlight">
                <i class="fas fa-plus-circle"></i>
                <span>Add Job</span>
            </a>
            
            <div class="user-profile">
                <span class="user-name"><?php echo explode(" ", trim($data['fullname']))[0]; ?></span>
                <div class="user-avatar">
                    <img src='candidate-image/<?php echo $data['image']; ?>' alt="User Avatar" class="avatar-img" />
                </div>

                <div class="dropdown-menu">
                    <a href="admin_profile.php?check" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                    <a href="settings.jsp" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>