<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jobseeker Dashboard</title>
    <link rel="stylesheet" href="newcss/user-dashboard.css">
</head>
<body>

    <?php
        include("user_navbar.php");
    ?>


    <div class="welcome-banner">
        <h1>Welcome, <?php echo $data['fullname']; ?> 👋</h1>
        <p>You are logged in as <strong><?php echo $data['email']; ?></strong></p>
    </div>

    <div class="cards">
        <div class="card">
            <img src="https://img.icons8.com/ios-filled/50/8b5cf6/plus.png" alt="Create Profile" />
            <h3>Create Profile</h3>
            <p>Build a comprehensive profile to showcase your skills and experience.</p>
            <a href="?checkStatus" class="purple">Create Profile</a>
        </div>

        <div class="card">
            <img src="https://img.icons8.com/ios-filled/50/3b82f6/search.png" alt="Search Jobs" />
            <h3>Search Jobs</h3>
            <p>Find jobs that suit your skills and preferences.</p>
            <a href="search_job.php" class="blue">Search Jobs</a>
        </div>

        <div class="card">
            <img src="https://img.icons8.com/ios-filled/50/10b981/checked--v1.png" alt="Applied Jobs" />
            <h3>Applied Jobs</h3>
            <p>View the jobs you've applied to.</p>
            <a href="applied_job.php?checkApplied" class="green">View Applied Jobs</a>
        </div>

        <div class="card">
            <img src="candidate-image/<?php echo $data['image']; ?>" alt="Profile picture" class="profile-thumbnail" />
            <h3>Update Profile</h3>
            <p>Ensure your profile is up to date for potential employers.</p>
            <a href="?checkProfileStatus" class="yellow">Update Profile</a>
        </div>
    </div>

    <div class="footer">
        Activate Windows - Go to Settings to activate Windows.
    </div>

    <?php
        if(isset($_GET['checkStatus'])) {
            $email = $_SESSION['email'];

            $profileStatusResult = getUserProfileByID($email);

            $data = mysqli_fetch_assoc($profileStatusResult);

            $status = $data['profilestatus'];

            if($status == '1') {
                echo "
                    <script>
                        alert('You have already created your profile');
                        window.location.href= 'user_profile.php?checkProfileStatus';
                    </script>
                ";                
            } else {
                echo "
                    <script>
                        window.location.href='create_user_profile.php';
                    </script>
                ";                
            }
        }
    ?>

    <?php
        if(isset($_GET['checkProfileStatus'])) {
            $email = $_SESSION['email'];

            $profileStatusResult = getUserProfileByID($email); 

            $data = mysqli_fetch_assoc($profileStatusResult);

            $status = $data['profilestatus'];

            if($status == '1') {
                echo "
                    <script>
                        window.location.href= 'update_user_profile.php?edit';
                    </script>
                ";                
            } else {
                echo "
                    <script>
                        alert('You need to create your profile first.');
                        window.location.href='user_dashboard.php';
                    </script>
                ";                
            }
        }
    ?>

</body>
</html>