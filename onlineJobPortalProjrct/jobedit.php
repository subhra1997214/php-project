<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Job - JobBoard</title>
    <link rel="stylesheet" href="newcss/jobedit.css">
</head>
<body>
    <?php
        include('admin_navbar.php');
    ?>

  <?php
    if (isset($_GET['jobid'])) {
        $jobid = $_GET['jobid'];
    }
    
    $jobdetails = getDetailsById($jobid);

    $data = mysqli_fetch_assoc($jobdetails);
  ?>

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h1>Update Job Details</h1>
                <p>Modify the details below to update your job posting</p>
            </div>

            <form action="" method="post">
                <input type="hidden" id="jobid" name="jobid" value="<?php echo $data['jobid']; ?>" >
                
                <div class="form-group">
                    <label for="companyName">Company Name *</label>
                    <input type="text" id="companyName" name="companyname" value="<?php echo $data['companyname']; ?>">
                </div>

                <div class="form-group">
                    <label for="companyAddress">Company Address *</label>
                    <textarea id="companyAddress" name="companyaddress"><?php echo isset($data['companyaddress']) ? $data['companyaddress'] : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="jobTitle">Job Post *</label>
                    <input type="text" id="jobTitle" name="post" value="<?php echo $data['post']; ?>">
                </div>

                <div class="form-group">
                    <label for="jobDescription">Job Description *</label>
                    <textarea id="jobDescription" name="description"><?php echo $data['description']; ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jobType">Job Type *</label>
                        <select id="jobType" name="jobtype">
                            <option value="">Select job type</option>
                            <option value="full-time" <?php if (isset($data['jobtype']) && $data['jobtype'] === 'full-time') echo 'selected'; ?>>💼 Full-time</option>
                            <option value="part-time" <?php if (isset($data['jobtype']) && $data['jobtype'] === 'part-time') echo 'selected'; ?>>🕐 Part-time</option>
                            <option value="internship" <?php if (isset($data['jobtype']) && $data['jobtype'] === 'internship') echo 'selected'; ?>>🎓 Internship</option>
                            <option value="contract" <?php if (isset($data['jobtype']) && $data['jobtype'] === 'contract') echo 'selected'; ?>>📋 Contract</option>
                            <option value="freelance" <?php if (isset($data['jobtype']) && $data['jobtype'] === 'freelance') echo 'selected'; ?>>💻 Freelance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="workLocation">Work Location *</label>
                        <select id="workLocation" name="worklocation">
                            <option value="">Select work location</option>
                            <option value="remote" <?php if (isset($data['location']) && $data['location'] === 'remote') echo 'selected'; ?>>🏠 Remote</option>
                            <option value="on-site" <?php if (isset($data['location']) && $data['location'] === 'on-site') echo 'selected'; ?>>🏢 On-site</option>
                            <option value="hybrid" <?php if (isset($data['location']) && $data['location'] === 'hybrid') echo 'selected'; ?>>🔄 Hybrid</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="salary">Annual Salary (INR) *</label>
                        <input type="number" id="salary" name="salary" value="<?php echo $data['salary']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="endDate">Application End Date *</label>
                        <input type="date" id="endDate" name="enddate" value="<?php echo $data['enddate']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="skills">Required Skills *</label>
                    <textarea id="skills" name="skills"><?php echo $data['skills']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="qualification">Qualification Requirements *</label>
                    <textarea id="qualification" name="qualification"><?php echo $data['qualification']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Job Status *</label>
                    <select id="status" name="status">
                        <option value="select">Select job status</option>
                        <option value="ongoing" <?php if ($data['status'] === 'ongoing') echo 'selected'; ?>>🟢 Ongoing - Accepting Applications</option>
                        <option value="ended" <?php if ($data['status'] === 'ended') echo 'selected'; ?>>🔴 Ended - No Longer Accepting Applications</option>
                    </select>
                </div>

                <button type="submit" name="update" class="submit-btn">
                    Update Job Posting
                </button>
            </form>
        </div>
    </div>

    <?php

      if (isset($_POST['update'])) {

        $response = update($_POST);

        echo "<script>
            alert('Your job details updated successfully');
            window.location.href='manage_job.php';
        </script>"; 
      }
    ?>
</body>
</html>