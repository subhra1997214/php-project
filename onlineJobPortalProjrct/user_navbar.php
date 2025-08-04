<?php
    include("my_methods.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="newcss/user-navbar.css">
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


    <header class="header">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="navbar-brand">
                <a class="navbar-brand logo" href="index.php">
                    <div class="logo">CareerConnect</div>
                </a>
            </div>
        </div>

        <!-- Navigation Section -->
        <nav class="nav-section">
            <a href="index.php" class="nav-link active">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="user_dashboard.php" class="nav-link">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="user_profile.php?checkProfileStatus" class="nav-link">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="applied_job.php?checkApplied" class="nav-link">
                <i class="fas fa-briefcase"></i>
                <span>Applied Jobs</span>
            </a>
        </nav>

        <!-- Search Section -->
        <div class="search-section">
            <form action="" method="GET">
                <div class="search-box">
                    <input type="text" name="search" class="search-input" placeholder="Search jobs, companies...">
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- User Section -->
        <div class="user-section">
            <div class="user-menu">
                <img src="candidate-image/<?php echo $data['image']; ?>" style="width:50px; height:50px" alt="User Avatar" class="user-avatar">
                <span class="user-name">
                    <?php echo explode(" ", trim($data['fullname']))[0]; ?> </span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="dropdown">
                <a href="user_profile.php?checkProfileStatus" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="settings.html" class="dropdown-item">
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
    </header>
    <?php
        if(isset($_GET['search'])) {
            $searchInput = $_GET['search'];

            echo "
                <script>
                    window.location.href='search_job.php?search=$searchInput';
                </script>
            ";
        }
    ?>
</body>
</html>