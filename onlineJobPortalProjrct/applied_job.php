<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs - Your Career Dashboard</title>
    <link rel="stylesheet" href="newcss/applied_job.css">
</head>
<body>

    <?php
        include("user_navbar.php");
    ?>


    <div class='container'>
        <!-- Page Header -->
        <div class='page-header'>
            <h1 class='page-title'>Applied Jobs</h1>
            <p class='page-subtitle'>Track your job applications and stay organized</p>
        </div>

        <?php
            $accepted = $rejected = $pending = 0;

            if(isset($_GET['checkApplied'])) {
                $email = $_SESSION['email'];

                $allAppliedJobs = getAllAppliedJobs($email);

                $record = $allAppliedJobs->num_rows;

                if($record > 0) {
                    while($data = $allAppliedJobs->fetch_assoc()) {
                        $status = $data['applystatus'];
                        if($status == 'accepted') {
                            $accepted += 1;
                        } elseif ($status == 'rejected') {
                            $rejected += 1;
                        } elseif ($status == 'pending') {
                            $pending += 1;
                        }
                    }
                }
            }
        ?>
        <!-- Statistics Cards -->
        <div class=stats-grid>
            <div class='stat-card'>
                <div class='stat-number'><?php echo $record; ?></div>
                <div class='stat-label'>Total Applied</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'><?php echo $pending; ?></div>
                <div class='stat-label'>Under Review</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'><?php echo $accepted; ?></div>
                <div class='stat-label'>Interviews</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'><?php echo $rejected; ?></div>
                <div class='stat-label'>Rejected</div>
            </div>
        </div>

        <!-- Filters Section -->
        
        <!-- <div class='filters-section'>
            <h3 class='filters-title'>Filter Applications</h3>
            <div class='filters-grid'>
                <div class='filter-group'>
                    <label class='filter-label'>Status</label>
                    <select class='filter-select'>
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Under Review</option>
                        <option>Interview Scheduled</option>
                        <option>Rejected</option>
                    </select>
                </div>
                <div class='filter-group'>
                    <label class='filter-label'>Company</label>
                    <select class='filter-select'>
                        <option>All Companies</option>
                        <option>TechCorp</option>
                        <option>InnovateLab</option>
                        <option>FutureWorks</option>
                        <option>DataFlow</option>
                    </select>
                </div>
                <div class='filter-group'>
                    <label class='filter-label'>Job Type</label>
                    <select class='filter-select'>
                        <option>All Types</option>
                        <option>Full-time</option>
                        <option>Part-time</option>
                        <option>Contract</option>
                        <option>Internship</option>
                    </select>
                </div>
                <div class='filter-group'>
                    <label class='filter-label'>Date Applied</label>
                    <select class='filter-select'>
                        <option>All Dates</option>
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                    </select>
                </div>
            </div>
        </div> -->
       

        <?php
            if(isset($_GET['checkApplied'])) {
                $email = $_SESSION['email'];

                $applyDetails = getAllApplyjob($email);
    
                if($applyDetails-> num_rows > 0) {
                    while($data = $applyDetails->fetch_assoc()) {
                        $jobid = $data['jobid'];
                        $companyname = $data['companyname'];
                        $companyaddress = isset($data['companyaddress']) ? $data['companyaddress'] : 'Not specified';
                        $post = $data['post'];
                        $description = $data['description'];
                        $jobtype = isset($data['jobtype']) ? $data['jobtype'] : 'Not specified';
                        $worklocation = isset($data['location']) ? $data['location'] : 'Not specified';
                        $salary = $data['salary'];
                        $enddate = $data['enddate'];
                        $skills = $data['skills'];
                        $qualification = $data['qualification'];
                        $status = $data['status'];
                        $applydate = $data['applydate'];
                        $applystatus = $data['applystatus'];

                        // Format job type and work location
                        $jobTypeFormatted = ucfirst(str_replace('-', ' ', $jobtype));
                        $workLocationFormatted = ucfirst(str_replace('-', ' ', $worklocation));
                        // For change of status badge colour
                        $statusClass = '';
                        if($applystatus == 'accepted') {
                            $statusClass = 'status-accepted';
                        } elseif($applystatus == 'rejected') {
                            $statusClass = 'status-rejected';
                        } elseif($applystatus == 'pending') {
                            $statusClass = 'status-pending';
                        }

                        echo "
                            <!-- Jobs Grid -->
                            <div class='jobs-grid'>
                                <!-- Job Card  -->
                                <div class='job-card'>
                                    <div class='job-header'>
                                        <div>
                                            <h3 class='job-title'>$post</h3>
                                            <p class='job-company'>$companyname</p>
                                        </div>
                                        <span class='job-status $statusClass'>$applystatus</span>
                                    </div>
                                    <div class='job-details'>
                                        <div class='job-detail'>
                                            <div class='detail-icon'>📍</div>
                                            <span>$companyaddress</span>
                                        </div>
                                        <div class='job-detail'>
                                            <div class='detail-icon'>💰</div>
                                            <span>$salary</span>
                                        </div>
                                        <div class='job-detail'>
                                            <div class='detail-icon'>⏰</div>
                                            <span>$jobTypeFormatted</span>
                                        </div>
                                        <div class='job-detail'>
                                            <div class='detail-icon'>🏢</div>
                                            <span>$workLocationFormatted</span>
                                        </div>
                                    </div>
                                    <p class='job-description'>
                                        $description
                                    </p>
                                    <div class='job-actions'>
                                        <a href='view_more.php?jobid=$jobid' class='btn btn-primary'>View Details</a>
                                        <a href='?remove=$jobid' class='btn btn-secondary'>Remove</a>
                                    </div>
                                    <div class='applied-date'>Applied on $applydate</div>
                                </div>
                            </div>
                        ";
                    }
                } else {
                    echo "
                    <div class='empty-state'>
                        <i class='fas fa-inbox'></i>
                        <h2>No Applications Found</h2>
                        <p>You haven't applied for any jobs</p>
                    </div>
                    ";
                }
            }
        ?>
    </div>

    <?php
        if(isset($_GET['remove'])) {

            $jobid = $_GET['remove'];
            $email = $_SESSION['email'];

            $removeResult = removeJobDetails($jobid, $email);

            if($removeResult == 1) {
                echo "
                    <script>
                        alert('Job application removed successfully.');
                        window.location.href = 'applied_job.php?checkApplied';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Failed to remove the job application. Please try again.');
                        window.location.href = 'applied_job.php?checkApplied';
                    </script>
                ";                
            }
        }
    ?>
</body>
</html>