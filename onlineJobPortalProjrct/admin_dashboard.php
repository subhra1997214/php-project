<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="newcss/admin-dashboard.css">
</head>
<body>
    <?php
        include('admin_navbar.php');
        
    ?>


    <div class="dashboard-container">
        <!-- Rest of your content remains the same -->
        <div class="welcome-banner centered-text">
            <h1>Welcome, <?php echo $data['fullname']; ?> 👋</h1>
            <p>You are logged in as <strong> <?php echo $data['email']; ?> </strong></p>
        </div>

        <div class="dashboard-cards">
            <div class="card profile">
                <div class="card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3>Create Profile</h3>
                <p>Set up your company profile and details.</p>
                <a href="?checkstatus"><button><i class="fas fa-user-plus"></i>Create Profile</button></a>
            </div>

            <div class="card post">
                <div class="card-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h3>Post a Job</h3>
                <p>Create a job post and attract top talent.</p>
                <a href="add_new_job.php"><button><i class="fas fa-plus-circle"></i>Post Job</button></a>
            </div>

            <div class="card manage">
                <div class="card-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3>Manage Jobs</h3>
                <p>View and edit your job listings.</p>
                <a href="manage_job.php"><button><i class="fas fa-cogs"></i>Manage</button></a>
            </div>

            <div class="card view">
                <div class="card-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>View Candidates</h3>
                <p>Check selected candidates</p>
                <a href="all_selected_list.php"><button><i class="fas fa-eye"></i>View</button></a>
            </div>
        </div>
    </div>

    <?php
        if(isset($_GET['checkstatus'])) {

            $email = $_SESSION['email'];

            $profileStatusResult = getAdminProfileById($email);

            $data = mysqli_fetch_assoc($profileStatusResult);

            $status = $data['profilestatus'];

            if($status == "1") {
                echo "
                    <script>
                        alert('You have already created your profile');
                        window.location.href= 'admin_profile.php?check';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        window.location.href='create_admin_profile.php';
                    </script>
                ";
            }
        }
    ?>

</body>
</html>