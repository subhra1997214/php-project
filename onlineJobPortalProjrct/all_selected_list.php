<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selected Candidates</title>
    <link rel="stylesheet" href="newcss/all_selected_list.css">
</head>
<body>

    <?php
        include("admin_navbar.php");
    ?>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Selected Candidates</h1>
            <p class="page-subtitle">View all selected candidates organized by job positions</p>
        </div>

        <?php

        // for total job post
            $totalJob = getTotalJob();

            $countTotalJob = $totalJob->num_rows;

        //for total selected candidate
            $totalSelectedCandidate = getTotalSelected();

            $countTotalSelectedCandidate = $totalSelectedCandidate->num_rows;
        
        // for selection rate

            $allAppliedCandidate = getTotalAppliedCandidate();

            $countAllAppliedCandidate = $allAppliedCandidate->num_rows;
            if($countAllAppliedCandidate > 0) {
                $selectionRate = ($countTotalSelectedCandidate / $countAllAppliedCandidate) * 100;
            } else {
                $selectionRate = 0;
            }
        ?>

        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number"><?php echo "$countTotalJob" ; ?></span>
                <span class="stat-label">Job Posts</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo "$countTotalSelectedCandidate" ; ?></span>
                <span class="stat-label">Selected Candidates</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo "$selectionRate"."%" ; ?></span>
                <span class="stat-label">Selection Rate</span>
            </div>
        </div>

        <?php
            $jobresult = getAllJobQuery();

            if($jobresult->num_rows > 0) {
                while($job = $jobresult->fetch_assoc()) {
                    $jobid = $job['jobid'];
                    $jobpost = $job['post'];

                    $candidateResult = getCandidateQuery($jobid);

                    $count = $candidateResult->num_rows;

                    echo "<div class='job-post-card'>
                            <div class='job-post-header'>
                                <h2 class='job-title'>$jobpost</h2>
                                <p class='candidate-count'>$count Selected Candidates</p>
                            </div>
                            <div class='candidates-container'>
                                <div class='candidate-grid'>";
                    
                    while($data = $candidateResult->fetch_assoc()) {
                        $name = $data['fullname'];
                        $email = $data['email'];
                        $phone = $data['phone'];
                        $resume = $data['resume'];

                        echo "
                            <!-- Job Post : Software Engineer -->
                            <div class='candidate-card'>
                                <div class='candidate-name'>$name</div>
                                <div class='candidate-info'>
                                    <div class='info-item'>
                                        <span class='info-label'>Phone:</span>
                                        <span class='info-value'>+91 $phone</span>
                                    </div>
                                    <div class='info-item'>
                                        <span class='info-label'>Email:</span>
                                        <span class='info-value'>$email</span>
                                    </div>
                                </div>
                                <a href='user_photo_resume/$resume'>
                                    <button class='view-resume-btn'>View Resume</button>
                                </a>    
                            </div>
                        ";
                    }
                    echo "</div></div></div>"; // Close candidate-grid, container, card
                }
            } else {
                echo "<p>No selected candidates found.</p>";
            }
            echo '</div>'; // Close container
        ?>
</body>
</html>