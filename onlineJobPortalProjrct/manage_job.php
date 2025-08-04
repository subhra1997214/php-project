<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>View Job</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="newcss/manage_job.css">
</head>
<body>

  <!-- Include your existing navbar -->
  <?php
    include("admin_navbar.php");
  ?>

  <!-- Main Content -->
  <div class="main-container">
    <div class="page-header">
      <h1><i class="fas fa-briefcase"></i> Job Listings</h1>
      <p>Manage and view all your job postings</p>
    </div>

    <?php

      $email = $_SESSION['email'];
      $jobdetails = getAllDetails($email);
      $record = mysqli_num_rows($jobdetails);

      if ($record > 0) {
        while($data = mysqli_fetch_assoc($jobdetails)) {
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

          // Determine status class
          $statusClass = strtolower($status) === 'ongoing' ? 'status-open' : 'status-closed';
          // Format job type and work location
          $jobTypeFormatted = ucfirst(str_replace('-', ' ', $jobtype));
          $workLocationFormatted = ucfirst(str_replace('-', ' ', $worklocation));


          echo "
              <div class='job-card'>
                <div class='job-header'>
                  <h1>$post</h1>
                  <span class='status-badge $statusClass'>$status</span>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-building'></i> Company Name:</strong>
                  <p>$companyname</p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-map-marker-alt'></i> Company Address:</strong>
                  <p>$companyaddress</p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-file-alt'></i> Job Description:</strong>
                  <p>$description</p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-briefcase'></i> Job Type & Work Location:</strong>
                  <p>
                    <span class='job-type-badge'>💼 $jobTypeFormatted</span> &
                    <span class='work-location-badge'>📍 $workLocationFormatted</span>
                  </p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-money-bill-wave'></i> Annual Salary:</strong>
                  <p>₹ " . number_format((float)$salary) . "</p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-calendar-times'></i> Application End Date:</strong>
                  <p>$enddate</p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-code'></i> Required Skills:</strong>
                  <p>$skills</p>
                </div>

                <div class='job-detail'>
                  <strong><i class='fas fa-graduation-cap'></i> Qualification Requirements:</strong>
                  <p>$qualification</p>
                </div>
       
                <div class='job-actions'>
                  <a href='jobedit.php?jobid=$jobid' class='btn btn-edit'><i class='fas fa-edit'></i> Edit</a>
                  <a href='view_all_application.php?jobid=$jobid' class='btn btn-view'><i class='fas fa-users'></i> View Applications</a>
                  <a href='manage_job.php?jobid=$jobid' class='btn btn-delete'><i class='fas fa-trash-alt'></i> Delete</a>
                </div>
              </div>
            ";
        }
      } else {
        echo "
          <div class='empty-state'>
            <i class='fas fa-inbox'></i>
            <h2>No Jobs Found</h2>
            <p>There are currently no job postings available. Create your first job posting to get started!</p>
          </div>
        ";
      }
    ?>
  </div>

  <?php
    if(isset($_GET['jobid'])) {
      $jobid = $_GET['jobid'];

      $response = deleteJobDetails($jobid);

      if ($response == 1) {
          echo "<script>
                  alert('Delete successful');
                  window.location.href= 'manage_job.php';
              </script>";
      } else {
          echo "<script>
                  alert('Delete not successful');
                  window.location.href = 'manage_job.php';
              </script>";
      }
    }
  ?>
  
</body>
</html>