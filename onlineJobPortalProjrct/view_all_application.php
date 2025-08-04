<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Applications</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="newcss/view_all_application.css">
</head>
<body>
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>


    <?php
        include("admin_navbar.php");
    ?>


    <div class="container">
        <div class="header">
            <h2>Candidate Applications</h2>
        </div>

        <div class='candidates-grid'>

            <?php
                if(isset($_GET['jobid'])) {
                    $jobid = $_GET['jobid'];

                    $applicantDetails = getAppliedCandidate($jobid);

                    if($applicantDetails-> num_rows > 0) {
                        while($data = $applicantDetails->fetch_assoc()) {
                            $fullname = $data['fullname'];
                            $age = $data['age'];
                            $gender = $data['gender'];
                            $email = $data['email'];
                            $skills = $data['skills'];
                            $resume = $data['resume'];
                            $applystatus = $data['applystatus'];
                            
                            if ($applystatus == 'pending') {
                                echo "    
                                    <!-- Candidate 1 -->
                                    <div class='candidate-card'>
                                        <h3 class='candidate-name'>$fullname</h3>
                                        <p class='candidate-info'><span>Age:</span> <span>$age</span></p>
                                        <p class='candidate-info'><span>Gender:</span> <span class='gender-male'>$gender</span></p>
                                        <p class='candidate-info'><span>Skills:</span> <span>$skills</span></p>
                                        <div class='action-buttons'>
                                            <a href='user_photo_resume/$resume' class='btn btn-view'>View Details</a>
                                            <a href='?jobid=$jobid&accept=$email' class='btn btn-accept'>Accept</a>
                                            <a href='?jobid=$jobid&reject=$email' class='btn btn-reject'>Reject</a>
                                        </div>
                                    </div>
                                ";
                            }
                        }
                    }
                }
            ?>
        </div>
    </div>

    <?php
        if(isset($_GET['jobid']) && isset($_GET['accept'])) {
            $jobid = $_GET['jobid'];
            $userid =$_GET['accept'];

            $acceptResult = updateAppliedStatusAccept($jobid, $userid);

            echo "
                <script>
                    alert('$acceptResult');
                    window.location.href='view_all_application.php?jobid=$jobid';
                </script>
            ";
        }
    ?>

    <?php
        if(isset($_GET['jobid']) && isset($_GET['reject'])) {
            $jobid = $_GET['jobid'];
            $userid =$_GET['reject'];
            
            $rejectResult = updateAppliedStatusReject($jobid, $userid);

            echo "
                <script>
                    alert('$rejectResult');
                    window.location.href='view_all_application.php?jobid=$jobid';
                </script>
            ";
        }
    ?>
</body>
</html>