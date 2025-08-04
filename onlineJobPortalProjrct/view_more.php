<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Job Details</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="newcss/view_more.css">
</head>
<body>
    <?php
        include("user_navbar.php");
    ?>



    <?php
        if(isset($_GET['jobid'])) {
            $jobid = $_GET['jobid'];

                    $jobdetails = getJobDetailsById($jobid);

            if($jobdetails->num_rows > 0) {
                $data = $jobdetails->fetch_assoc();

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
                
                // Determine status class
                $statusClass = strtolower($status) === 'ongoing' ? 'status-open' : 'status-closed';
            }
        }
    ?>

  <!-- Main Content -->
    <div class="main-container">
        <div class="page-header">
            <h1><i class="fas fa-briefcase"></i> Job Details</h1>
            <p>Complete information about this position</p>
        </div>

        <div class='job-card'>
            <div class='job-header'>
                <h1><?php echo $post ;?></h1>
                <span class='status-badge <?php echo $statusClass ;?>'><?php echo $status ;?></span>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-building'></i> Company Name:</strong>
                <p><?php echo $companyname ;?></p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-map-marker-alt'></i> Company Address:</strong>
                <p><?php echo $companyaddress ;?></p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-file-alt'></i> Job Description:</strong>
                <p><?php echo $description ;?></p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-briefcase'></i> Job Type & Work Location:</strong>
                <p>
                <span class='job-type-badge'>💼 <?php echo $jobtype ;?></span>
                <span class='work-location-badge'>📍 <?php echo $worklocation ;?></span>
                </p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-money-bill-wave'></i> Annual Salary:</strong>
                <p><?php echo $salary ;?></p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-calendar-times'></i> Application End Date:</strong>
                <p><?php echo $enddate ;?></p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-code'></i> Required Skills:</strong>
                <p><?php echo $skills ;?></p>
            </div>

            <div class='job-detail'>
                <strong><i class='fas fa-graduation-cap'></i> Qualification Requirements:</strong>
                <p><?php echo $qualification ;?></p>
            </div>
        </div>
    </div>

</body>
</html>