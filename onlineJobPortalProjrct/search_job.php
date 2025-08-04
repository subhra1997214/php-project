<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>View Job</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="newcss/search_job.css">
</head>
<body>

  <!-- Navbar placeholder -->
  <nav class="navbar">
    <?php
      include("user_navbar.php");
    ?>
  </nav>



  <!-- Main Content -->
  <div class="main-container">
    <div class="page-header">
      <h1><i class="fas fa-briefcase"></i> Job Listings</h1>
      <p>Browse and apply for available positions</p>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-wrapper">
        <form action="" method="GET">
            <div class="search-box">
              <input type="text" name="search" placeholder="Search jobs by title, company..." class="search-input">
              <button type="submit" class="search-button">
                  <i class="fas fa-search"></i>
              </button>
            </div>
            <!-- <div class="filter-options">
            <select name="location" class="filter-select">
                <option value="">All Locations</option>
                <option value="New York">New York</option>
                <option value="San Francisco">San Francisco</option>
                <option value="Chicago">Chicago</option>
            </select>
            <select name="type" class="filter-select">
                <option value="">All Types</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Remote">Remote</option>
            </select>
            </div> -->
        </form>
        </div>
    </div>

    <?php
      if(isset($_GET['search'])) {

        $searchInput = $_GET['search'];

        $email = $_SESSION['email'];

        $searchResult = searchJob($searchInput, $email);

        $record = mysqli_num_rows($searchResult);

        if($record > 0) {
          while($row = mysqli_fetch_assoc($searchResult)) {
            $jobid = $row['jobid'];
            $companyname = $row['companyname'];
            $companyaddress = isset($row['companyaddress']) ? $row['companyaddress'] : 'Not specified';
            $post = $row['post'];
            $description = $row['description'];
            $jobtype = isset($row['jobtype']) ? $row['jobtype'] : 'Not specified';
            $worklocation = isset($row['location']) ? $row['location'] : 'Not specified';
            $salary = $row['salary'];
            $enddate = $row['enddate'];
            $skills = $row['skills'];
            $qualification = $row['qualification'];
            $status = $row['status'];

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
                  <p>₹ " . number_format($salary) . "</p>
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
                  <a href='?jobid=$jobid' class='btn btn-apply'><i class='fas fa-paper-plane'></i> Apply Now</a>
                </div>
              </div>
            ";
          }
        } else {
            echo "
              <div class='empty-state'>
                <i class='fas fa-inbox'></i>
                <h2>No Jobs Found</h2>
                <p>There are currently no job available!</p>
              </div>
            ";
        }
      } else {
          $jobDetails = getAllJobDetails($email);

          $record = mysqli_num_rows($jobDetails);

          if($record > 0) {
            while($row = mysqli_fetch_assoc($jobDetails)) {

              $jobid = $row['jobid'];
              $companyname = $row['companyname'];
              $companyaddress = isset($row['companyaddress']) ? $row['companyaddress'] : 'Not specified';
              $post = $row['post'];
              $description = $row['description'];
              $jobtype = isset($row['jobtype']) ? $row['jobtype'] : 'Not specified';
              $worklocation = isset($row['location']) ? $row['location'] : 'Not specified';
              $salary = $row['salary'];
              $enddate = $row['enddate'];
              $skills = $row['skills'];
              $qualification = $row['qualification'];
              $status = $row['status'];

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
                  <p>₹ " . number_format($salary) . "</p>
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
                  <a href='?jobid=$jobid' class='btn btn-apply'><i class='fas fa-paper-plane'></i> Apply Now</a>
                </div>
              </div>
            ";
            }
          } else {
              echo "
              <div class='empty-state'>
                <i class='fas fa-inbox'></i>
                <h2>No Jobs Found</h2>
                <p>There are currently no job available!</p>
              </div>
            ";
          }
        }
    ?>
  </div>

  <?php
    if(isset($_GET['jobid'])) {
      $email = $_SESSION['email'];
      $jobid = $_GET['jobid'];

      $allUserDetails = getUserProfileByID($email);

      $data = mysqli_fetch_assoc($allUserDetails);

      $resumeStatus = $data['resumestatus'];

      if($resumeStatus == '0') {
        echo "
          <script>
            alert('Please submit your Resume first');
            window.location.href='update_user_profile.php?edit';
          </script>
        ";
      } else {
        $res = applyJob($jobid, $email);
         echo "
          <script>
            alert('$res');
            window.location.href='applied_job.php?checkApplied';
          </script>
        ";      
      }
    }
  ?>
</body>
</html>